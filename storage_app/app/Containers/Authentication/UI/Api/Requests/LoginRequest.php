<?php

namespace App\Containers\Authentication\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @SWG\Definition(
 *     definition="UserAuth",
 *     type="object",
 *     required={
 *       "email",
 *       "password"
 *     },
 *     @SWG\Property(property="email", type="string", example="john@dou.com"),
 *     @SWG\Property(property="password", type="string", example="againstUsingQwerty"),
 *     @SWG\Xml(name="UserAuth")
 * )
 */
/**
 * Class LoginRequest
 * @package App\Containers\Authentication\UI\Api\Requests
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'deviceToken' => ['string','max:255'],
            'email'    => ['required','email'],
            'password' => ['required'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
