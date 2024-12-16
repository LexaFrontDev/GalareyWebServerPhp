<?php


namespace App\Query\GetQuery;


use App\Query\GetQuery\Query;

class GetRefreshTokens extends Query
{

    public function getRefreshTokens($ref){
        $sql = 'SELECT * FROM users.Refresh_tokens WHERE refresh_token = :refresh_token';
        $execute = ['refresh_token' => $ref];
        return $this->fetch($sql, $execute, 'Рефреш токен некорректен');

    }

}