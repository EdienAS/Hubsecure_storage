<?php

namespace App\Containers\Share\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use App\Containers\Files\Rules\DisabledMimetypes;

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
 * Class PublicUploadChunksSharedItemRequest.
 *
 */
class PublicUploadChunksSharedItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'                  => 'required|in:uuid',
            'parent_folder_id'      => 'sometimes|integer|exists:folders,id',
            'path'                  => 'sometimes|string',
            'is_last_chunk'         => 'required|boolean',
            'extension'             => 'required|string|nullable',
            'files'                 => 'required|array|max:1',
            'files.0'               => ['required', 'file', new DisabledMimetypes],
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
