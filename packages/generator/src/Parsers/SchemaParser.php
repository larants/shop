<?php

namespace Leading\Generator\Parsers;

use Doctrine\DBAL\Schema\Column;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Str;

/**
 * 获取数据库Schema，用于生成注释和属性
 *
 * Class SchemaParser
 * @package Leading\Generator\Parsers
 */
class SchemaParser implements Arrayable
{
    // abstract type
    const TYPE_PK        = 'pk';
    const TYPE_UPK       = 'upk';
    const TYPE_CHAR      = 'char';
    const TYPE_STRING    = 'string';
    const TYPE_TEXT      = 'text';
    const TYPE_TINYINT   = 'tinyint';
    const TYPE_SMALLINT  = 'smallint';
    const TYPE_INTEGER   = 'integer';
    const TYPE_BIGINT    = 'bigint';
    const TYPE_FLOAT     = 'float';
    const TYPE_DOUBLE    = 'double';
    const TYPE_DECIMAL   = 'decimal';
    const TYPE_DATETIME  = 'datetime';
    const TYPE_TIMESTAMP = 'timestamp';
    const TYPE_TIME      = 'time';
    const TYPE_DATE      = 'date';
    const TYPE_BINARY    = 'binary';
    const TYPE_BOOLEAN   = 'boolean';
    const TYPE_MONEY     = 'money';
    const TYPE_JSON      = 'json';

    /**
     * @var string
     */
    public $table;


    /**
     * @var DatabaseManager
     */
    protected $manager;

    /**
     * SchemaParser constructor.
     * @param DatabaseManager $manager
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param string $table
     * @param null $connection
     * @return mixed
     */
    public function getColumns($table, $connection = null)
    {
        // 使用复数
        $this->table = Str::plural($table);
        $connection = $this->manager->connection($connection);
        $table = $connection->getTablePrefix() . $table;
        $columns = $connection->getDoctrineSchemaManager()->listTableColumns($this->table);
        if (!$columns) {
            // 使用单数
            $this->table = Str::singular($table);
            $columns = $connection->getDoctrineSchemaManager()->listTableColumns($this->table);
        }
        foreach ($columns as $key => $column) {
            // 转为PHP的类型
            $column->setCustomSchemaOption('type', $this->getColumnType($column));
            $columns[$key] = $column->toArray();
        }

        return $columns;
    }


    public function toArray()
    {
        return [];
    }


    /**
     * 类型转换
     *
     * @param Column $column
     * @return mixed|string
     */
    protected function getColumnType(Column $column)
    {
        static $typeMap = [
            // abstract type => php type
            self::TYPE_TINYINT => 'integer',
            self::TYPE_SMALLINT => 'integer',
            self::TYPE_INTEGER => 'integer',
            self::TYPE_BIGINT => 'integer',
            self::TYPE_BOOLEAN => 'boolean',
            self::TYPE_FLOAT => 'double',
            self::TYPE_DOUBLE => 'double',
            self::TYPE_BINARY => 'resource',
            self::TYPE_JSON => 'array',
        ];
        $columnType = $column->getType()->getName();
        if (isset($typeMap[$columnType])) {
            if ($columnType === 'bigint') {
                return PHP_INT_SIZE === 8 && !$column->getUnsigned() ? 'integer' : 'string';
            } elseif ($columnType === 'integer') {
                return PHP_INT_SIZE === 4 && $column->getUnsigned() ? 'string' : 'integer';
            }

            return $typeMap[$columnType];
        }

        return 'string';
    }
}
