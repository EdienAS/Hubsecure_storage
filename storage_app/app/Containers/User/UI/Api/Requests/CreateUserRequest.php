<?php

namespace App\Containers\User\UI\Api\Requests;

use URL;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="Register/CreateUser",
 *     type="object",
 *     required={
 *       "name",
 *       "email",
 *       "password",
 *       "role_id"
 *     },
 *     @SWG\Property(property="name", type="string", example="john"),
 *     @SWG\Property(property="email", type="string", example="john@dou.com"),
 *     @SWG\Property(property="password", type="string", example="AgainstQwertyPassword"),
 *     @SWG\Property(property="role_id", type="integer", example=1),
 *     ),
 *     @SWG\Xml(name="Register/CreateUser")
 * )
 */
/**
 * Class CreateUserRequest.
 *
 * @author <>
 */
class CreateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'     => 'required|in:uuid',
            'name'     => 'required|string',
            'email'    => 'required',
            'password' => 'required',
            'role_id'  => 'required|integer',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(str_contains(URL::current(), 'register') == false){
                abort_if(Gate::denies('management_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');    
        }        

        return true;
    }
}
