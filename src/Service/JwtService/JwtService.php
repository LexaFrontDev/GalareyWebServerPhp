<?php


namespace App\Service\JwtService;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;


abstract class JwtService
{


    protected function fetchPrivatePem()
    {
        $privateKeyPath = 'src/Jwt/private.pem';
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("Приватный ключ не существует по пути $privateKeyPath");
        }
        $privateKey = file_get_contents($privateKeyPath);
        return $privateKey;
    }

    protected function fetchPublicPem()
    {
        $publicKeyPath = 'src/Jwt/public.pem';
        if (!file_exists($publicKeyPath)) {
            throw new \Exception("Приватный ключ не существует по пути $publicKeyPath");
        }
        $publicKey = file_get_contents($publicKeyPath);
        return $publicKey;
    }

    public function accEncode($token, $algorithm){
        $acc = JWT::encode($token ,$this->fetchPrivatePem(), $algorithm);
        return $acc;
    }

    public function accDecode($accToken, $usePublicKey = false, $algorithm = 'RS256'){
        $key = $usePublicKey ? $this->fetchPublicPem() : $this->fetchPrivatePem();
        $decoded = JWT::decode($accToken, new Key($key, $algorithm));
        $payload = (array)$decoded;
        $data = isset($payload['data']) ? (array)$payload['data'] : null;

        if ($data) {
            return ['payload' => $payload, 'data' => $data, 'username' => $data['username'] ?? null];
        } else {
            throw new \Exception('Данные отсутствуют в декодированном токене');
        }
    }

}