<?php

namespace App\Containers\Teams\UI\Api\Requests;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListTeamInvitationRequest.
 *
 */
class ListTeamInvitationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return[];
    }

    /**
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_team_invitation_list'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
