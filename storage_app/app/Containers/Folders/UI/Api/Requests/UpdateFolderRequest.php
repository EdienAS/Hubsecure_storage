<?php

namespace App\Containers\Folders\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Validation\Rule;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Definition(
 *     definition="UpdateFolder",
 *     type="object",
 *     @SWG\Property(property="id", type="integer", example="1"),
 *     @SWG\Property(property="name", type="string", example="john"),
 *     ),
 *     @SWG\Xml(name="UpdateFolder")
 * )
 */
/**
 * Class UpdateFolderRequest.
 *
 */
class UpdateFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $folder = Folder::where('uuid', $this->route('uuid'))->first();
        return [
            'id'            => 'prohibited',
            'user_id'       => 'prohibited',
            'parent_folder_id'     => 'prohibited',
            'author_id'     => 'prohibited',
            'created_at'    => 'prohibited',
            'updated_at'    => 'prohibited',
            'deleted_at'    => 'prohibited',
            'uuid'          => 'required|uuid|exists:folders,uuid',
            'name'          => 'string|' . Rule::unique('folders')->where(function ($query) use ($folder) {
                                                    return $query->where([
                                                        'user_id' => auth()->id(),
                                                        'parent_folder_id' => $folder->parent_folder_id,
                                                        'team_folder'      => $folder->team_folder
                                                    ]); 
                                                
                                                })->ignore($folder->id),
            'color'         => 'string',
            'emoji'         => 'string',
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

        if(Auth::user()->role_id == 1 || Auth::user()->id == Folder::
                where('uuid', $this->route('uuid'))->first()
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
