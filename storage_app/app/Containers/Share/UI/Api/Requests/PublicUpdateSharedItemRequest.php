<?php

namespace App\Containers\Share\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublicUpdateSharedItemRequest.
 *
 */
class PublicUpdateSharedItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'           => 'prohibited',
            'parent_folder_id'  => 'prohibited',
            'mimetype'          => 'prohibited',
            'filesize'          => 'prohibited',
            'type'              => 'prohibited',
            'author_id'         => 'prohibited',
            'creator_id'        => 'prohibited',
            'created_at'        => 'prohibited',
            'updated_at'        => 'prohibited',
            'deleted_at'        => 'prohibited',
            'id'                => 'required|integer',
            'shared'            => 'required',
            'name'              => 'string',
            'color'             => 'string',
            'emoji'             => 'string',
            'type'              => 'required|in:file,folder',
            '_method'           => 'required|in:patch'
            
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
        $data['id'] = $this->route('id');
        $data['shared'] = $this->route('shared');
        
        return $data;
    }
    
}
