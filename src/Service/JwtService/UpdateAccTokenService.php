<?php


namespace App\Service\JwtService;

use App\Service\JwtService\GenerateTokenService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Query\GetQuery\GetRefreshTokens;
use App\Service\JwtService\JwtService;

class UpdateAccTokenService extends JwtService
{
    private $generateAccToken;
    private $getRefToken;

    public function __construct(GenerateTokenService $generateAccToken, GetRefreshTokens $getRefToken)
    {
        $this->generateAccToken = $generateAccToken;
        $this->getRefToken = $getRefToken;
    }

    public function updateToken($ref)
    {
        if (empty($ref)) {
            throw new \Exception('Токен не передан');
        }

        $isCheckRefToken = $this->getRefToken->getRefreshTokens($ref);

        $decoded = $this->accDecode($ref, false, 'HS256');

        if ($decoded) {
            $data = $decoded['data'];
            $name = $data['username'];
            $acc = $this->generateAccToken->generateAccToken($name);
            return ['messages' => 'Токен успешно обновлен', 'acc' => $acc];
        }

        throw new \Exception('Не удалось обновить токен');
    }
}
