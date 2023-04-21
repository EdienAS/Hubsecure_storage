<?php

namespace App\Containers\User\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="UpdateUser",
 *     type="object",
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="name", type="string", example="john"),
 *     @SWG\Property(property="email", type="email", example="john@dou.com"),
 *     @SWG\Property(property="role_id", type="integer", example=1),
 *     ),
 *     @SWG\Xml(name="UpdateUser")
 * )
 */
/**
 * Class UpdateUserRequest.
 *
 */
class UpdateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    => 'prohibited',
            'email_verified_at'     => 'prohibited',
            'remember_token'        => 'prohibited',
            'created_at'            => 'prohibited',
            'updated_at'            => 'prohibited',
            'deleted_at'            => 'prohibited',
            'uuid'                  => 'required|uuid|exists:users,uuid',
            'name'                  => 'string',
            'email'                 => 'email',
            'role_id'               => 'integer',
            'is_active'             => 'integer|in:0,1',
            '_method'               => 'required|in:patch'
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
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if((Auth::user()->role_id == 1 && Auth::user()->uuid != $this->route('uuid')) || 
           (Auth::user()->uuid == $this->route('uuid') && !isset(parent::all()['is_active']) && !isset(parent::all()['role_id']))
            ){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
