<?php

namespace App\Containers\Authorization\UI\Api\Requests\Role;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="CreateRole",
 *     type="object",
 *     required={
 *       "title",
 *       "password"
 *     },
 *     @SWG\Property(property="title", type="string", example="test"),
 *     ),
 *     @SWG\Xml(name="CreateRole")
 * )
 */
/**
 * Class CreateRoleRequest.
 *
 */
class CreateRoleRequest extends FormRequest
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
            'title'     => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('role_create'), 
                Response::HTTP_FORBIDDEN, 
                '403 Forbidden');

        return true;
    }
}
