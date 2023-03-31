<?php

namespace App\Containers\Authorization\UI\Api\Requests\Role;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListRoleRequest.
 *
 */
class ListRoleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    
    /**
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('list_role'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
