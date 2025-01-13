<?php

namespace App\Controller\AuthControllerDirectory;



use App\Service\WorkWithJson\Request;
use App\Service\WorkWithJson\JsonResponse;
use App\Service\UsersServiceDirectory\RegisterUser;
use App\Service\JwtService\GenerateTokenService;
use App\Service\JwtService\RefGenerateTokenService;


class RegisterController
{

    private $request;
    private $response;
    private $registerService;
    private $generateAccToken;
    private $generateRefToken;

    public function __construct(GenerateTokenService $generateAccToken, RefGenerateTokenService $generateRefToken, RegisterUser $registerService, JsonResponse $response, Request $request){
        $this->generateRefToken = $generateRefToken;
        $this->generateAccToken = $generateAccToken;
        $this->registerService = $registerService;
        $this->request = $request;
        $this->response = $response;
    }


    public function register(){
        $request = $this->request->getRequest();
            $data = $request['data'];
            $name =  $data['name'];
            $password = $data['password'];

            try{
                $isRegister = $this->registerService->registerUser($name, $password);

                var_dump($isRegister);
                if($isRegister){
                    $acc = $this->generateAccToken->generateAccToken($name);
                    $ref = $this->generateRefToken->generateRefToken($name);
                    $header = ['Acc' => $acc['acc'], 'Ref' => $ref['ref']];
                    return $this->response->sendResponse($isRegister['messages'], 201, $header);
                }
                return $this->response->sendError('Не удалось зарегестрировать пользователя', 400);
            }catch (\PDOException $e) {
                if ($e->getCode() == '23505') {
                    return $this->response->sendError('Пользователь с таким именем уже существует', 400);
                }
                return $this->response->sendError($e->getMessage(), 400);
            }
    }

}