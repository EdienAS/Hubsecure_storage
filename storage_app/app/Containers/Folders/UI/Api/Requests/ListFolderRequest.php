<?php

namespace App\Containers\Folders\UI\Api\Requests;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Abstracts\RequestHttp;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListFolderRequest.
 *
 */
class ListFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return[];
    }

    /**
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return mixed
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_folder_list'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return true;
    }
}
