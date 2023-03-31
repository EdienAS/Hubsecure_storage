<?php

namespace App\Containers\Teams\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
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
 * Class UpdateTeamFolderRequest.
 *
 */
class UpdateTeamFolderRequest extends FormRequest
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
            'parent_folder_id'     => 'prohibited',
            'author_id'     => 'prohibited',
            'created_at'    => 'prohibited',
            'updated_at'    => 'prohibited',
            'deleted_at'    => 'prohibited',
            'uuid'          => 'required|uuid|exists:folders,uuid',
            'members'                  => 'present|array',
            'members.*.permission'     => 'required|string',
            'members.*.id'             => 'required|integer',
            'invitations'              => 'present|array',
            'invitations.*.email'      => 'required|email',
            'invitations.*.permission' => 'required|string',
            'invitations.*.type'       => 'required|string',
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
        abort_if(Gate::denies('user_team_folder_update'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(Auth::user()->role_id == 1 || Auth::user()->id == Folder::
                where('uuid', $this->route('uuid'))->first()
                ->getLatestParent()->user->id){
                      
            // Authorize action
            Gate::authorize('owner', [Folder::
                where('uuid', $this->route('uuid'))
                ->where('team_folder', 1)->first()]);
                        
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
