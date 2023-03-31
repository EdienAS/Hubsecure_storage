<?php

namespace App\Containers\UserSettings\UI\Api\Requests;

use Auth;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserSettingsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'      => 'required|uuid|exists:users,uuid',
            'file_storage_option_id' => 'required|integer|in:1',
            'storage_limit_mb' => 'integer',
            '_method'   => 'required|in:patch'
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
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_settings_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');   
        
        if((Auth::user()->role_id == 1 && Auth::user()->uuid != $this->route('uuid')) || 
           (Auth::user()->uuid == $this->route('uuid') && !in_array('storage_limit_mb', parent::all()))){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
