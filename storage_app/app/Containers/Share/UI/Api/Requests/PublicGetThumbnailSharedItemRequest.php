<?php

namespace App\Containers\Share\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublicGetThumbnailSharedItemRequest.
 *
 */
class PublicGetThumbnailSharedItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string',
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
        $data['shared'] = $this->route('shared');
        
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
