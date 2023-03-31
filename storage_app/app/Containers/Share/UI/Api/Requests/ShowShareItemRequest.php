<?php

namespace App\Containers\Share\UI\Api\Requests;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Containers\Share\Models\Share;

/**
 * Class ShowShareItemRequest.
 *
 */
class ShowShareItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token'    => 'required|string|exists:shares,token'
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
