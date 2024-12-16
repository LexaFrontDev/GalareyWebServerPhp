<?php

namespace App\Service\Roles;

use App\Service\WorkWithJson\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Service\JwtService\JwtService;
use App\Query\GetQuery\GetUsers;

class RouteRoles extends JwtService
{


    private $request;
    private $getUsers;

    public function __construct(GetUsers $getUsers,Request $request)
    {
        $this->getUsers = $getUsers;
        $this->request = $request;
    }

    public function onlyUsers(){
        $request = $this->request->getRequest();
        $accToken = $request['token'];

        $decode = $this->accDecode($accToken);
        $payload = $decode['payload'];
        $data = $decode['data'];

        if ($payload['exp'] < time()) {
            throw new \Exception('Token просрочен');
        }
        if (!isset($data['username'], $data['roles'])) {
            throw new \Exception('Некорректный payload токена');
        }

        $user = $this->getUsers->getUsers($data['username']);

        if($user['roles'] === ['ROLE_USERS']){
            return true;
        }

        throw new \Exception('Пользовател не зарегестрирован');
    }

    public function onlyAdmins(){
        $request = $this->request->getRequest();
        $accToken = $request['token'];

        $decode = $this->accDecode($accToken);
        $payload = $decode['payload'];
        $data = $decode['data'];

        if ($payload['exp'] < time()) {
            throw new \Exception('Token просрочен');
        }
        if (!isset($data['username'], $data['roles'])) {
            throw new \Exception('Некорректный payload токена');
        }

        $user = $this->getUsers->getUsers($data['username']);

        if($user['roles'] === ['ROLE_ADMIN']){
            return true;
        }

        throw new \Exception('Пользовател не зарегестрирован');
    }


}