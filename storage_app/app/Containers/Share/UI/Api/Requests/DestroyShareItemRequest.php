<?php

namespace App\Containers\Share\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DestroyShareItemRequest.
 *
 */
class DestroyShareItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tokens'     => 'required|array',
            'tokens.*'   => 'string|exists:shares,token',
            '_method'       => 'required|in:delete'
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

        return $data;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_team_folder_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

            return true;
    }
}
