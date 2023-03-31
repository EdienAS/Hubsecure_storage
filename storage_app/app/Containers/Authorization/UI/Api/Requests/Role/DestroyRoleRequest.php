<?php

namespace App\Containers\Authorization\UI\Api\Requests\Role;

use App\Abstracts\RequestHttp;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyRoleRequest.
 *
 */
class DestroyRoleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid' => 'required|uuid|exists:roles,uuid'
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
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('role_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
