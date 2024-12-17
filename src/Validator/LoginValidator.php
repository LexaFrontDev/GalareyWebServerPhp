<?php


namespace App\Validator;

use App\Model\DatabaseConfig\DatabaseConnect;
use App\Query\GetQuery\GetUsers;

class LoginValidator
{

    private $getUsers;

    public function __construct(GetUsers $getUsers)
    {
        $this->getUsers = $getUsers;
    }

    public function loginValidate($name, $password)
    {

        if (empty($name) && empty($password)) {
            throw new \Exception('Имя и Пароль не должны быть пустыми');
        }


        $user = $this->getUsers->getAllColumnsUsersByName($name);

        if (!$user) {
            throw new \Exception('Пользователь с таким именем не существует');
        }

        if (password_verify($password, $user['hshpassword'])) {
            return [
                'messages' => 'Пользователь успешно залогинился',
                'success' => true
            ];
        } else {
            throw new \Exception('Неверный пароль');
        }
    }
}
