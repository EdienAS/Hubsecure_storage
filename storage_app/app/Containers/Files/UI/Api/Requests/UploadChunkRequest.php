<?php
namespace App\Containers\Files\UI\Api\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Containers\Files\Rules\DisabledMimetypes;


class UploadChunkRequest extends FormRequest
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
        abort_if(Gate::denies('user_file_upload'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return true;
    }
}
