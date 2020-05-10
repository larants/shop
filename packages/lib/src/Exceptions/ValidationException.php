<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/5
 */

namespace Leading\Lib\Exceptions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use Illuminate\Validation\Validator;

/**
 * Class ValidationException
 * @package Leading\Lib\Exceptions
 */
class ValidationException extends LaravelValidationException
{

    /**
     * @param array $messages
     * @param $code
     * @throws ValidationException
     */
    public static function throw(array $messages, int $code = 0)
    {
        throw (new static(tap(ValidatorFacade::make([], []), function (Validator $validator) use ($messages) {
            foreach ($messages as $key => $value) {
                foreach (Arr::wrap($value) as $message) {
                    $validator->errors()->add($key, $message);
                }
            }
        })))->setCode($code);
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}