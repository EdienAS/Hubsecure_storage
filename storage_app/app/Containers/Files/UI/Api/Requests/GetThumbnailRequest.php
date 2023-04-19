<?php

namespace App\Containers\Files\UI\Api\Requests;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Containers\Files\Models\File;

/**
 * Class GetThumbnailRequest.
 *
 */
class GetThumbnailRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|string'
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
        $data['name'] = (string)$this->route('name');
        
        return $data;
    }
    
    /**
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_file_get'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        
        
        if(Auth::user()->role_id == 1 || Auth::user()->id == File::
                where('basename', substr($this->route('name'), 3))->first()
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
