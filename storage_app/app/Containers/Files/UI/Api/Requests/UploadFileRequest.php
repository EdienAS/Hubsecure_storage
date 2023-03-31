<?php

namespace App\Containers\Files\UI\Api\Requests;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="UploadFile",
 *     type="object",
 *     required={
 *       "file",
 *     },
 *     @SWG\Property(property="file", type="file", example=""),
 *     ),
 *     @SWG\Xml(name="UploadFile")
 * )
 */
/**
 * Class UploadFileRequest.
 *
 */
class UploadFileRequest extends FormRequest
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
            'files'     => 'required|array',
            'files.*'   => 'file',
            'parent_folder_id' => 'sometimes|integer|exists:folders,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_file_upload'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }
}
