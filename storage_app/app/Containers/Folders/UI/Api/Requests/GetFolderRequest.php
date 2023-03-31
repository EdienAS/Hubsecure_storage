<?php

namespace App\Containers\Folders\UI\Api\Requests;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Containers\Folders\Models\Folder;

/**
 * Class GetFolderRequest.
 *
 */
class GetFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'    => 'required|uuid|exists:folders,uuid'
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
        $data['uuid'] = (string)$this->route('uuid');
        $data['items'] = (string)$this->route('uuid') . '|folder';
        
        return $data;
    }
    
    /**
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_folder_get'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(Auth::user()->role_id == 1 || Auth::user()->id == Folder::
                where('uuid', $this->route('uuid'))->first()
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
