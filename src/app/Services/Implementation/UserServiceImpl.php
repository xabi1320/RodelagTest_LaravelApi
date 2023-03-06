<?php
namespace App\Services\Implementation;

use App\Services\Interfaces\IUserServiceInterface;
use App\Models\User;

class UserServiceImpl implements IUserServiceInterface
{

    private $model;

    function __construct() {

        $this->model = new User();
    }

    /**
     * Return all episodes
     */
    function getUser() {
        return $this->model->withTrashed()->get();
    }

    function getUserById(int $id) {

    }

    /**
     * Create new episode
     */
    function postUser(array $user) {

        $this->model->create($user);
    }

    function patchUser(array $user, int $id) {

        $this->model->where('id', $id)
        ->first()
        ->fill($user)
        ->save();
    }

    function delUser(int $id) {
        $user = $this->model->find($id);

        if ($user) {
            $user->delete();
        }
    }

    function restoreUser(int $id) {
        $user = $this->model->withTrashed()->find($id);

        if ($user) {
            $user->restore();
        }
    }

}
