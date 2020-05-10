<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator;


use Doctrine\DBAL\Schema\Column;
use Illuminate\Support\Str;

/**
 * Class ModelGenerator
 * @package Leading\Generator
 */
class ModelGenerator extends AbstractGenerator
{

    /**
     * @var string
     */
    protected $type = 'model';

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $skipAttrs = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var string[]
     */
    protected $castTypes = [
        'array'
    ];

    /**
     * 注释信息
     * @var string
     */
    protected $annotations = '';

    /**
     * 表名
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $fillable = '';

    /**
     * @var string
     */
    protected $casts = '';

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        $this->handleReplacements();

        return array_merge(parent::getReplacements(), [
            'annotations' => $this->annotations,
            'table' => $this->table,
            'fillable' => $this->fillable,
            'casts' => $this->casts
        ]);
    }

    /**
     * 处理替换内容
     */
    public function handleReplacements(): void
    {
        $annotations = [];
        $fillable = [];
        $casts = [];
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            $type = $column['type'];
            $name = $column['name'];
            $annotations[] = <<<COL
 * @property {$type} \${$name}
COL;

            if (!in_array($name, $this->skipAttrs)) {
                $fillable[] = "'{$name}'";
            }

            if (in_array($type, $this->castTypes)) {
                $casts[] = "'{$name}' => '{$type}'";
            }
        }
        $this->annotations = ltrim(implode("\n", $annotations), ' * ');
        if ($fillable) {
            $this->fillable = "\n\t\t" . implode(",\n\t\t", $fillable) . "\n\t";
        }
        if ($casts) {
            $this->casts = "\n\t\t" . implode(",\n\t\t", $casts) . "\n\t";
        }
    }

    /**
     * @return Column[]
     */
    protected function getColumns()
    {
        // 获取table的字段
        $table = Str::snake($this->getName());
        $columns = $this->schemaParser->getColumns($table, $this->option('connection'));
        $this->table = $this->schemaParser->table;

        return $columns;
    }
}