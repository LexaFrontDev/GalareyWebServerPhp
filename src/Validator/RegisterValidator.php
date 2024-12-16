<?php
namespace App\Validator;

use App\Model\DatabaseConfig\DatabaseConnect;

class RegisterValidator
{

    public function validator($name,  $password){
        if(empty($name) && empty($password)){
            throw new \Exception('Имя и Пароль не должны быть пустыми');
        }

        $isCountName = mb_strlen($name, 'UTF-8');
        $isCountPassword = mb_strlen($password);

        if($isCountName < 3){
            throw new \Exception('Количество букв в имени не должно быть меньше 3');
        }

        if($isCountPassword < 8){
            throw new \Exception('Пароль должен содержать минимум 8 символов');
        }

        $passwordRegex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if (!preg_match($passwordRegex, $password)) {
            throw new \Exception('Пароль должен содержать хотя бы одну заглавную букву, одну цифру и один специальный символ');
        }

        $db = new DatabaseConnect();
        $pdo  = $db->getConnection();
        $sql = 'SELECT * FROM users.Users WHERE name = :name';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
        $user = $stmt->fetch();

        if($user){
            throw new \Exception('Пользователь с таким именем уже существует');
        }

        return ['name' => $name, 'password' => $password];
    }
}