<?php

namespace App\Containers\Files\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use App\Containers\Files\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="MoveFile",
 *     type="object",
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="parent_folder_id", type="integer", example="1"),
 *     ),
 *     @SWG\Xml(name="UpdateFile")
 * )
 */
/**
 * Class MoveFileRequest.
 *
 */
class MoveFileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'prohibited',
            'user_id'       => 'prohibited',
            'name'          => 'prohibited',
            'basename'      => 'prohibited',
            'mimetype'      => 'prohibited',
            'filesize'      => 'prohibited',
            'type'          => 'prohibited',
            'creator_id'    => 'prohibited',
            'created_at'    => 'prohibited',
            'updated_at'    => 'prohibited',
            'deleted_at'    => 'prohibited',
            'uuid'          => 'required|uuid|exists:files,uuid',
            'parent_folder_id'     => 'required|integer|exists:folders,id',
            '_method'       => 'required|in:patch'
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

        if(Auth::user()->role_id == 1 || Auth::user()->id == File::
                where('uuid', $this->route('uuid'))->first()
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
