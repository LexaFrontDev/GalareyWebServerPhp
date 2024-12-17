<?php

namespace App\Service\JwtService;


use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use App\Service\JwtService\JwtService;
use App\Query\GetQuery\GetUsers;

class GenerateTokenService extends JwtService
{

    private $getUsers;

    public function __construct
    (
        GetUsers $getUsers
    )
    {
        $this->getUsers = $getUsers;
    }


    public function generateAccToken($name){
        $user = $this->getUsers->getUsersByName($name);
        $issuedat_claim = time();
        $access = $issuedat_claim + 900;



        $access_token = array(
            "iat" => $issuedat_claim,
            "exp" => $access,
            "data" => array(
                "id" => $user['id'],
                "username" => $user['name'],
                "roles" => $user['roles']
            )
        );

        $acc = $this->accEncode($access_token, 'RS256');

        return ['acc' => $acc];
    }

}