<?php

namespace App\Containers\XRPLBlock\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use App\Containers\Files\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XrplUploadRequest.
 *
 */
class XrplUploadRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'    => 'required|uuid|exists:files,uuid'
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
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_file_upload'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(Auth::user()->id == File::where([
                                'uuid'=> $this->route('uuid'),
                                'file_storage_option_id' => 1
                                ])->first()
                                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
        
    }
}
