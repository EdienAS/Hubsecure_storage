<?php

namespace App\Containers\Authorization\UI\Api\Requests\Permission;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListPermissionRequest.
 *
 */
class ListPermissionRequest extends FormRequest
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
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('list_permission'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
