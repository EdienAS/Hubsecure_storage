<?php

namespace App\Containers\Browse\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use App\Containers\Folders\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BrowseSharedWithMeRequest.
 *
 */
class BrowseSharedWithMeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'    => 'uuid|exists:folders,uuid'
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
        if(!empty($this->route('uuid'))){
            $data['uuid'] = $this->route('uuid');
        }
        
        return $data;
    }
    
    /**
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_shared_with_me_browse'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        if(!empty($this->route('uuid'))){
            if(in_array(Auth::user()->id, Folder::where('uuid', $this->route('uuid'))->first()->teamMembers()->whereIn('permission', ['can-edit', 'can-view'])->pluck('user_id')->toArray())){
                return true;
            } else {
                abort(403, 'Unauthorized action.');
            }
        } else {
            return true;
        }
    }
}
