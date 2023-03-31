<?php

namespace App\Containers\Authorization\UI\Api\Requests\Permission;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShowPermissionRequest.
 *
 */
class ShowPermissionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'    => 'required|uuid|exists:permissions,uuid'
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
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
