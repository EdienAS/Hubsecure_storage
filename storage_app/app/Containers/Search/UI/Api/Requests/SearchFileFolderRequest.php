<?php

namespace App\Containers\Search\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SearchFileFolderRequest.
 *
 */
class SearchFileFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query'    => 'required|string'
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
        
        return true;
            
    }
}
