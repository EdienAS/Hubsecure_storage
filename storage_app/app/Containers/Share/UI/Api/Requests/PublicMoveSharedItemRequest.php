<?php

namespace App\Containers\Share\UI\Api\Requests;

use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublicMoveSharedItemRequest.
 *
 */
class PublicMoveSharedItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'prohibited',
            'user_id'       => 'prohibited',
            'name'          => 'prohibited',
            'basename'      => 'prohibited',
            'mimetype'      => 'prohibited',
            'filesize'      => 'prohibited',
            'type'          => 'prohibited',
            'color'         => 'prohibited',
            'emoji'         => 'prohibited',
            'team_folder'   => 'prohibited',
            'author_id'     => 'prohibited',
            'creator_id'    => 'prohibited',
            'created_at'    => 'prohibited',
            'updated_at'    => 'prohibited',
            'deleted_at'    => 'prohibited',
            'shared'                  => 'required',
            'parent_folder_id'        => 'nullable|integer',
            'items.*.type'            => 'required|string|in:file,folder',
            'items.*.id'              => 'required|integer',
            '_method'       => 'required|in:patch'
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
