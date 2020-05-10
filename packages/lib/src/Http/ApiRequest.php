<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-12
 */

namespace Leading\Lib\Http;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Leading\Lib\Exceptions\ValidationException;

/**
 * Class ApiRequest
 * @package Leading\Lib\Http
 */
abstract class ApiRequest extends FormRequest
{
    /**
     * @var int
     */
    protected $errorCode = 422001;

    /**
     * @return array
     */
    abstract function rules();

    /**
     * todo 鉴权，暂时返回true
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * 重新定义异常信息，添加errorCode
     *
     * @param Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->setCode($this->errorCode)
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}