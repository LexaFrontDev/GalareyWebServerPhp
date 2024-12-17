<?php

namespace App\Service\Roles;

use App\Service\WorkWithJson\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Service\JwtService\JwtService;
use App\Query\GetQuery\GetUsers;
use App\Service\WorkWithJson\JsonResponse;

class RouteRoles extends JwtService
{


    private $request;
    private $getUsers;
    private $jsonResponse;

    public function __construct(JsonResponse $jsonResponse ,GetUsers $getUsers,Request $request)
    {
        $this->jsonResponse = $jsonResponse;
        $this->getUsers = $getUsers;
        $this->request = $request;
    }

    public function onlyUsers(){
        $request = $this->request->getRequest();
        $accToken = $request['token'];

        if(!$accToken){
            throw new \Exception('Пользовател не авторизован');
        }

        $decode = $this->accDecode($accToken, true);
        $payload = $decode['payload'];
        $data = $decode['data'];

        if ($payload['exp'] < time()) {
            throw new \Exception('Token просрочен');
        }
        if (!isset($data['username'], $data['roles'])) {
            throw new \Exception('Некорректный payload токена');
        }

        $roles = json_decode($data['roles'], true);
        if (in_array('ROLE_USER', $roles)) {
            return true;
        }

        throw new \Exception('Пользовател не зарегестрирован');
    }

    public function onlyAdmins(){
        $request = $this->request->getRequest();
        $accToken = $request['token'];

        if(!$accToken){
            throw new \Exception('Пользовател не авторизован');
        }

        $decode = $this->accDecode($accToken);
        $payload = $decode['payload'];
        $data = $decode['data'];

        if ($payload['exp'] < time()) {
            throw new \Exception('Token просрочен');
        }
        if (!isset($data['username'], $data['roles'])) {
            throw new \Exception('Некорректный payload токена');
        }

        $user = $this->getUsers->getUsersByName($data['username']);

        $roles = json_decode($user['roles'], true);
        if (in_array('ROLE_ADMIN', $roles)) {
            return true;
        }

        throw new \Exception('Пользовател не зарегестрирован');
    }


}