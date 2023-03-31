<?php

namespace App\Containers\Authorization\UI\Api\Requests\Role;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowRoleRequest.
 *
 */
class ShowRoleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'    => 'required|uuid|exists:roles,uuid', // url parameter
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
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
