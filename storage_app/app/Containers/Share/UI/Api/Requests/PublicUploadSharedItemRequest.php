<?php

namespace App\Containers\Share\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

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
 * Class PublicUploadSharedItemRequest.
 *
 */
class PublicUploadSharedItemRequest extends FormRequest
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
        return true;
    }
}
