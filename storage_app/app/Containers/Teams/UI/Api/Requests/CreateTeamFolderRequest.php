<?php
namespace App\Containers\Teams\UI\Api\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class CreateTeamFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'                     => 'required|in:uuid',
            'name'                     => 'required|string',
            'invitations'              => 'required|array',
            'invitations.*.email'      => 'required|email',
            'invitations.*.permission' => 'required|string|in:can-edit,can-view,can-view-and-download',
            'invitations.*.type'       => 'required|string|in:invitation',
        ];
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_team_folder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return true;
    }
}
