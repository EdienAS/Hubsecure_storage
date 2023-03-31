<?php

namespace App\Containers\Share\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use App\Containers\Share\Models\Share;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateShareItemRequest.
 *
 */
class UpdateShareItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'prohibited',
            'uuid'              => 'prohibited',
            'user_id'           => 'prohibited',
            'item_id'           => 'prohibited',
            'type'              => 'prohibited',
            'token'             => 'required|string|exists:shares,token',
            'is_protected'      => 'boolean',
            'password'          => 'required_if:is_protected,true|string',
            'permission'        => 'sometimes|in:visitor,editor',
            'expiration'        => 'sometimes|integer',
            '_method'           => 'required|in:patch'
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
        $data['token'] = $this->route('token');
        
        return $data;
    }
    
    /**
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_share_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        if(Auth::user()->role_id == 1 || Auth::user()->id == Share::where('token', $this->route('token'))->first()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
