<?php
namespace App\Containers\Share\UI\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateShareRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string',
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
}
