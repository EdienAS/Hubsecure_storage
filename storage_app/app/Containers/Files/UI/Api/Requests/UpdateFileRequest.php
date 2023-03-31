<?php

namespace App\Containers\Files\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Validation\Rule;
use App\Containers\Files\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="UpdateFile",
 *     type="object",
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="name", type="string", example="john"),
 *     ),
 *     @SWG\Xml(name="UpdateFile")
 * )
 */
/**
 * Class UpdateFileRequest.
 *
 */
class UpdateFileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $file = File::where('uuid', $this->route('uuid'))->first();
        return [
            'id'                => 'prohibited',
            'user_id'           => 'prohibited',
            'parent_folder_id'         => 'prohibited',
            'mimetype'          => 'prohibited',
            'filesize'          => 'prohibited',
            'type'              => 'prohibited',
            'creator_id'        => 'prohibited',
            'created_at'        => 'prohibited',
            'updated_at'        => 'prohibited',
            'deleted_at'        => 'prohibited',
            'uuid'              => 'required|uuid|exists:files,uuid',
            'name'              => 'string|' . Rule::unique('files')->where(function ($query) use ($file) {
                                                    return $query->where([
                                                        'user_id' => auth()->id(),
                                                        'parent_folder_id' => $file->parent_folder_id
                                                    ]); 
                                                
                                                })->ignore($file->id),
            '_method'           => 'required|in:patch'
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
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_file_update'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $file = File::where('uuid', $this->route('uuid'))->first();
        
        abort_if($file->file_storage_option_id != 1, Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if(Auth::user()->role_id == 1 || Auth::user()->id == $file
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
