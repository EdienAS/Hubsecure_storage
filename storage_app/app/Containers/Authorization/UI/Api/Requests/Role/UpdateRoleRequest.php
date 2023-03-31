<?php

namespace App\Containers\Authorization\UI\Api\Requests\Role;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="UpdateRole",
 *     type="object",
 *     required={
 *       "email",
 *       "password"
 *     },
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="email", type="string", example="john@dou.com"),
 *     @SWG\Property(property="password", type="string", example="AgainstQwertyPassword"),
 *     @SWG\Property(property="deviceToken", type="string", example="mF5...9nI"),
 *     @SWG\Property(property="data", type="object",
 *         @SWG\Property(property="name", type="string", example="john"),
 *         @SWG\Property(property="gender", type="string", example="male"),
 *         @SWG\Property(property="birthday", type="string", format="date", example="2000-01-01"),
 *         @SWG\Property(property="height", type="integer", example="180"),
 *         @SWG\Property(property="weight", type="number", format="double", example="180"),
 *     ),
 *     @SWG\Xml(name="RegisterUser")
 * )
 */
/**
 * Class UpdateRoleRequest.
 *
 */
class UpdateRoleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'prohibited',
            'created_at'        => 'prohibited',
            'updated_at'        => 'prohibited',
            'deleted_at'        => 'prohibited',
            'uuid'                => 'required|uuid|exists:roles,uuid',
            'title'             => 'required',
            '_method'           => 'required|in:patch'
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
        abort_if(Gate::denies('role_update'), 
                Response::HTTP_FORBIDDEN, 
                '403 Forbidden');

        return true;
    }
}
