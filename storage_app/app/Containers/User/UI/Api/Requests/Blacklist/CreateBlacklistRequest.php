<?php

namespace App\Containers\User\UI\Api\Requests\Blacklist;

use URL;
use Auth;
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
 * Class CreateBlacklistRequest.
 *
 * @author <>
 */
class CreateBlacklistRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'  => 'required|uuid|exists:users,uuid',
        ];
    }

    /**
     * Override the all() to automatically apply validation rules to the URL parameters
     *
     * @param null $keys
     * @return  array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        
        $data['uuid'] = $this->route('uuid');
        
        return $data;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('management_user_blacklist'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(Auth::user()->role_id == 1 && Auth::user()->uuid != $this->route('uuid')){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
