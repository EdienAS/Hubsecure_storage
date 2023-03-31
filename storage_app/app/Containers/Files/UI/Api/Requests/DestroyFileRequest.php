<?php

namespace App\Containers\Files\UI\Api\Requests;

use Auth;
use Gate;
use App\Abstracts\RequestHttp;
use App\Containers\Files\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DestroyFileRequest.
 *
 */
class DestroyFileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'            => 'required|uuid|exists:files,uuid',
            'force_delete'  => 'required|in:1',
            '_method'       => 'required|in:delete'
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
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_file_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        if(Auth::user()->role_id == 1 || Auth::user()->id == File::withTrashed()
                ->where('uuid', $this->route('uuid'))->first()
                ->getLatestParent()->user->id){
            return true;
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
