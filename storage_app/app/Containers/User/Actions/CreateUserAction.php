<?php

namespace App\Containers\User\Actions;

use App\Abstracts\RequestHttp;
use App\Containers\User\Tasks\CreateUserTask;
use App\Abstracts\Action;
use Illuminate\Support\Facades\Validator;
use DB;

/**
 * Class CreateUserAction.
 *
 */
class CreateUserAction extends Action
{

    /**
     * @var  CreateUserTask
     */
    private $createUserTask;
    
    
    /**
     * CreateUserAction constructor.
     *
     * @param \App\Containers\User\Tasks\CreateUserTask     $createUserTask
     */
    public function __construct(
        CreateUserTask $createUserTask
    ) {
        $this->createUserTask = $createUserTask;
    }
    
    
    /**
     * @param RequestHttp $request
     * @param bool $login
     *
     * @return mixed
     */
    public function run($request, $login = false)
    {
        $data = $request->all();

         $userEmailExistcheck = DB::table('users')->where('email', $data['email'])->first();

        // @todo: refactoring
        $userExistsValidator = Validator::make($request->all(), ['email' => 'unique:users']);
        if ($userExistsValidator->fails()) {
           // throw new ValidationHttpException($userExistsValidator->errors()->getMessages());
            $errors = $userExistsValidator->errors()->getMessages();
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(
               [
                   'message' => "The email has already been taken.",
                   'errors' => $errors
               ], \Illuminate\Http\JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }

        $user = $this->createUserTask->run($data, $login);
        
        return $user;
    }
}
