<?php

namespace App\Containers\Authorization\UI\Api\Requests\Permission;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="UpdatePermission",
 *     type="object",
 *     required={
 *       "id",
 *       "title"
 *     },
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="title", type="string", example="test"),
 *     ),
 *     @SWG\Xml(name="RegisterUser")
 * )
 */
/**
 * Class UpdatePermissionRequest.
 *
 */
class UpdatePermissionRequest extends FormRequest
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
            'uuid'                => 'required|uuid|exists:permissions,uuid',
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
        abort_if(Gate::denies('permission_update'), 
                Response::HTTP_FORBIDDEN, 
                '403 Forbidden');

        return true;
    }
}
