<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-13
 */

namespace Leading\Lib\Exceptions;


use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;

/**
 * Class HttpException
 * @package Leading\Lib\Exceptions
 */
class HttpException extends SymfonyHttpException
{

    /**
     * HttpException constructor.
     * @param int $statusCode 状态吗
     * @param string|null $message 错误信息
     * @param int $code 错误码
     * @param Exception|null $previous
     * @param array $headers
     */
    public function __construct(
        int $statusCode,
        string $message = null,
        int $code = 0,
        Exception $previous = null,
        array $headers = array()
    )
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @param int $statusCode
     */
    public static function throw(string $message, int $code = 0, int $statusCode = 400)
    {
        throw new static($statusCode, $message, $code);
    }
}