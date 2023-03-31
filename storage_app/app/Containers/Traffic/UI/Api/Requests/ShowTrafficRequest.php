<?php

namespace App\Containers\Traffic\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShowTrafficRequest.
 *
 */
class ShowTrafficRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'    => 'required|uuid|exists:users,uuid', // url parameter
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
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_traffic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(Auth::user()->role_id == 1 || Auth::user()->uuid == $this->route('uuid')){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
