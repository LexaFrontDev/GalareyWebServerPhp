<?php


namespace App\Service\JwtService;

use App\Command\InsertCommand\InsertRefToken;
use Firebase\JWT\JWT;
use App\Query\GetQuery\GetRefreshTokens;
use App\Command\UpdateCommand\UpdateTokenCommand;
use App\Query\GetQuery\GetUsers;
use App\Service\JwtService\JwtService;

class RefGenerateTokenService extends JwtService
{
    private $insertRef;
    private $getRef;
    private $updateRef;
    private $getUsers;

    public function __construct(GetUsers $getUsers,UpdateTokenCommand $updateRef,GetRefreshTokens $getRef,InsertRefToken $insertRef)
    {
        $this->getUsers = $getUsers;
        $this->updateRef = $updateRef;
        $this->getRef = $getRef;
        $this->insertRef = $insertRef;
    }

    public function generateRefToken($name)
    {
        if (empty($name)) {
            throw new \Exception('Имя не может быть пустыми');
        }

        $users = $this->getUsers->getUsersByName($name);

        if(!$users){
            throw new \Exception('Пользовател не найдень');
        }

        $issuedat_claim = time();
        $refresh = $issuedat_claim + 2592000;

        $refresh_token = array(
            "iat" => $issuedat_claim,
            "exp" => $refresh,
            "data" => array(
                "id" => $users['id'],
                "username" => $users['name'],
                "roles" => $users['roles']
            )
        );

        $jwt_refresh = $this->accEncode($refresh_token, 'HS256');

        $isUsers = $this->getUsers->getUsersInRef($name);

        if(!$isUsers){
            $isInsertRefToken = $this->insertRef->insertRefToken($name, $jwt_refresh);
            if ($isInsertRefToken) {
                return ['ref' => $jwt_refresh];
            }
        }

        $updateRefToken = $this->updateRef->update($name, $jwt_refresh);

        if ($updateRefToken) {
            return ['ref' => $jwt_refresh];
        }

        throw new \Exception('Не удалось создать refresh токен');
    }
}
