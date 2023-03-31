<?php

namespace App\Containers\Files\UI\Api\Requests;

use Gate;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestoreFileRequest.
 *
 */
class RestoreFileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'to_home'      => 'sometimes|boolean',
            'items'        => 'array',
            'items.*.type' => 'required|string|in:file',
            'items.*.uuid'   => 'required|uuid|exists:files,uuid',
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

        return $data;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_file_restore'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

            return true;
    }
}
