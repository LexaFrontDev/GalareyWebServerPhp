<?php


namespace App\Controller\RefTokenController;

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

use App\Service\WorkWithJson\JsonResponse;
use App\Service\JwtService\UpdateAccTokenService;
use App\Service\WorkWithJson\Request;

class UpdateAccToken
{
    private $updateToken;
    private $request;
    private $response;

    public function __construct(JsonResponse $response ,Request $request ,UpdateAccTokenService $updateToken)
    {
        $this->response = $response;
        $this->request = $request;
        $this->updateToken = $updateToken;
    }

    public function updateTokenController(){
        $request = $this->request->getRequest();
        $token = $request['token'];

        try{

            $isUpdate = $this->updateToken->updateToken($token);
            if($isUpdate){
                return $this->response->sendResponse($isUpdate['messages'], 201, $isUpdate['acc']);
            }

            return $this->response->sendError('Не удалось обновить токен', 400);
        }catch (\Exception $e){
            return $this->response->sendError($e->getMessage(), 400);
        }
    }



}