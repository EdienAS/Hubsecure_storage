<?php

namespace App\Containers\Folders\UI\Api\Requests;

use URL;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="CreateFolder",
 *     type="object",
 *     required={
 *       "name",
 *       "parent_folder_id"
 *     },
 *     @SWG\Property(property="name", type="string", example="john"),
 *     @SWG\Property(property="parent_folder_id", type="integer", example=1),
 *     ),
 *     @SWG\Xml(name="CreateFolder")
 * )
 */
/**
 * Class CreateFolderRequest.
 *
 */
class CreateFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_folder' => 'prohibited',
            'uuid'     => 'required|in:uuid',
            'parent_folder_id' => 'nullable|integer',
            'name'      => 'required|string',
            'color' => 'string',
            'emoji' => 'string'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(str_contains(URL::current(), 'sharing') == false){
            abort_if(Gate::denies('user_folder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
        return true;
    }
}
