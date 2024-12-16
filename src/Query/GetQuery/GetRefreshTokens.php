<?php


namespace App\Query\GetQuery;


use App\Query\GetQuery\FetchAssocQuery;

class GetRefreshTokens
{
    private $fetchAssoc;

    public function __construct(FetchAssocQuery $fetchAssoc)
    {
        $this->fetchAssoc = $fetchAssoc;
    }

    public function getRefreshTokens($ref){
        $sql = 'SELECT * FROM users.Refresh_tokens WHERE refresh_token = :refresh_token';
        $execute = ['refresh_token' => $ref];
        return $this->fetchAssoc->fetch($sql, $execute, 'Рефреш токен некорректен');

    }

}