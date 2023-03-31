<?php

namespace App\Containers\Authorization\UI\Api\Requests\Permission;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="CreatePermission",
 *     type="object",
 *     required={
 *       "title"
 *     },
 *     @SWG\Property(property="title", type="string", example="test"),
 *     ),
 *     @SWG\Xml(name="CreatePermission")
 * )
 */
/**
 * Class CreatePermissionRequest.
 *
 */
class CreatePermissionRequest extends FormRequest
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
            'title'     => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('permission_create'), 
                Response::HTTP_FORBIDDEN, 
                '403 Forbidden');

        return true;
    }
}
