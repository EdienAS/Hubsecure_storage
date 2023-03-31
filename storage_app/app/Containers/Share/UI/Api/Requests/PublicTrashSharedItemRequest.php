<?php

namespace App\Containers\Share\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublicTrashSharedItemRequest.
 *
 */
class PublicTrashSharedItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shared'                  => 'required',
            'items'                   => 'required|array|min:1',
            'items.*.type'            => 'required|string|in:file,folder',
            'items.*.id'              => 'required|integer',
            '_method'                 => 'required|in:delete'
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
        $data['shared'] = $this->route('shared');
        
        return $data;
    }
    
}
