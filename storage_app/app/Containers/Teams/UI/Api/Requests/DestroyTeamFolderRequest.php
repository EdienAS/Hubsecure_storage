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
 * Class DestroyTeamFolderRequest.
 *
 */
class DestroyTeamFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'          => 'required|uuid|exists:folders,uuid'
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
        abort_if(Gate::denies('user_team_folder_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

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
