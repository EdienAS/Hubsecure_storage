<?php

namespace App\Containers\Folders\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="MoveFolder",
 *     type="object",
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="parent_folder_id", type="integer", example="1"),
 *     ),
 *     @SWG\Xml(name="UpdateFolder")
 * )
 */
/**
 * Class MoveFolderRequest.
 *
 */
class MoveFolderRequest extends FormRequest
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
            'color'         => 'prohibited',
            'emoji'         => 'prohibited',
            'team_folder'   => 'prohibited',
            'author_id'     => 'prohibited',
            'created_at'    => 'prohibited',
            'updated_at'    => 'prohibited',
            'deleted_at'    => 'prohibited',
            'uuid'          => 'required|uuid|exists:folders,uuid',
            'parent_folder_id'     => 'required|integer|exists:folders,id|',
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
        abort_if(Gate::denies('user_folder_update'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        abort_if($this->route('uuid') == Folder::find((int) parent::all()['parent_folder_id'])->uuid, Response::HTTP_FORBIDDEN, ''); 
        
        if(Auth::user()->role_id == 1 || Auth::user()->id == Folder::
                where('uuid', $this->route('uuid'))->first()
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
