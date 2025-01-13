<?php

namespace App\Service\UsersServiceDirectory;

use App\Validator\RegisterValidator;
use App\Command\InsertCommand\InsertUsersCommand;


class RegisterUser
{
    private $registerValidator;
    private $createUsers;

    public function __construct(InsertUsersCommand $createUsers, RegisterValidator $registerValidator){
        $this->createUsers = $createUsers;
        $this->registerValidator = $registerValidator;
    }


    public function registerUser($name, $password){

        $isValid = $this->registerValidator->validator($name, $password);

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        if(!$hashPassword){
            throw new \Exception('Парол не хэширован');
        }

        $isCreated = $this->createUsers->insert($name, $hashPassword);

        if(!$isCreated){
            throw new \Exception('Не удалось зарегестрировать пользователя');
        }

        return ['messages' => 'Пользовател успешно зарегестрировалься'];
    }

}
