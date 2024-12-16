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


        try {
            $decoded = $this->accDecode($ref, false, 'HS256');
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new \Exception('Токен истек');
        } catch (\Firebase\JWT\BeforeValidException $e) {
            throw new \Exception('Токен не валиден до указанного времени');
        } catch (\Exception $e) {
            throw new \Exception('Ошибка декодирования токена');
        }

        if ($decoded) {
            $data = $decoded['data'];
            $name = $data['username'];
            $acc = $this->generateAccToken->generateAccToken($name);
            return ['messages' => 'Токен успешно обновлен', 'acc' => $acc];
        }

        throw new \Exception('Не удалось обновить токен');
    }
}
