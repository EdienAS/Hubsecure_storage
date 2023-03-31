<?php

namespace App\Containers\Share\UI\Api\Requests;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShareItemRequest.
 *
 */
class ShareItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_uuid'     => 'required|uuid',
            'uuid'          => 'required|in:uuid',
            'isPassword'    => 'sometimes|boolean',
            'password'      => 'required_if:isPassword,true',
            'type'          => 'required|in:file,folder',
            'expiration'    => 'sometimes|integer',
            'permission'    => 'required_if:type,folder|in:visitor,editor',
            'emails'        => 'sometimes|array',
            'emails.*'      => 'email',
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
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_share_item'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

            return true;
    }
}
