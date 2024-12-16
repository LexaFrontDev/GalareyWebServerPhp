<?php


namespace App\Service\JwtService;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Service\JwtService\GenerateTokenService;
use App\Validator\GetPrivatePemValidator;
use App\Service\JwtService\JwtService;

class CheckToken extends JwtService
{

    private $accGenerate;


    public function __construct(GenerateTokenService $accGenerate)
    {
        $this->accGenerate = $accGenerate;
    }

    public function checkAccToken($accToken){

        if (empty($accToken)) {
            throw new \Exception('Access токен не может быть пустым');
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

        $acc = $this->accGenerate->generateAccToken($data['username']);

        return ['acc' => $acc];
    }

}