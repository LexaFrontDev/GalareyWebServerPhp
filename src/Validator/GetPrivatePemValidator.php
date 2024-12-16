<?php


namespace App\Validator;


class GetPrivatePemValidator
{

    public function get(){
        $privateKeyPath = 'src/Jwt/private.pem';
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("Приватный ключ не существует по пути $privateKeyPath");
        }
        $privateKey = file_get_contents($privateKeyPath);


        return $privateKey;
    }

}