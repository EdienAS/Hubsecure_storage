<?php

namespace App\Containers\Teams\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Containers\Teams\Models\TeamFolderInvitation;

/**
 * @SWG\Definition(
 *     definition="DestroyTeamInvitation",
 *     type="object",
 *     @SWG\Property(property="uuid", type="uuid"),
 *     ),
 * )
 */
/**
 * Class DestroyTeamInvitationRequest.
 *
 */
class DestroyTeamInvitationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'          => 'required|uuid|exists:team_folder_invitations,uuid'
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
        abort_if(Gate::denies('user_team_invitation_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(in_array(Auth::user()->email, TeamFolderInvitation
                ::where('uuid', $this->route('uuid'))->pluck('email')->toArray()) || 
            Auth::user()->id == TeamFolderInvitation
                ::where('uuid', $this->route('uuid'))->pluck('inviter_id')->first()){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
