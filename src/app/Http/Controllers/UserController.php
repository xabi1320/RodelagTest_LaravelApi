<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Implementation\UserServiceImpl;
use App\Validator\UserValidator;

class UserController extends Controller
{
    /**
     * @var UserServiceImpl
    */
    private $userService;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var UserValidator
     */
    private $validator;

    public function __construct(
        UserServiceImpl $userService,
        Request $request,
        UserValidator $userValidator
    )
    {
        $this->userService = $userService;
        $this->request = $request;
        $this->validator = $userValidator;
    }

    function createUser()
    {
        $response = response("", 201);
        $validator = $this->validator->validate();

        if ($validator->fails()) {
            $response = response([
                "status" => 422,
                "message" => "Error",
                "errors" => $validator->errors(),
            ], 422);
        } else {
            $this->userService->postUser($this->request->all());
        }

        return $response;
    }

    function getListUser()
    {
        return response($this->userService->getUser());
    }

    function patchUser(int $id)
    {
        $response = response("", 202);

        $this->userService->patchUser($this->request->all(), $id);

        return $response;
    }

    function deleteUser(int $id)
    {
        $this->userService->delUser($id);

        return response("", 204);
    }

    function restoreUser(int $id)
    {
        $this->userService->restoreUser($id);

        return response("", 204);
    }
}
