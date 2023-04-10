<?php

namespace App\Containers\UserSettings\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Containers\UserSettings\Models\Usersetting;

/**
 * Class GetUserAvatarRequest.
 *
 */
class GetUserAvatarRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|string', // url parameter
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
        $data['name'] = $this->route('name');
        
        return $data;
    }
    
    /**
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_settings_show'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        if(Auth::user()->role_id == 1 || Auth::user()->id == Usersetting::
                where('avatar', substr($this->route('name'), 3))->first()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
