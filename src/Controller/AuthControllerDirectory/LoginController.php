<?php


namespace App\Controller\AuthControllerDirectory;


use App\Service\JwtService\GenerateTokenService;
use App\Service\JwtService\RefGenerateTokenService;
use App\Service\WorkWithJson\Request;
use App\Service\WorkWithJson\JsonResponse;
use App\Validator\LoginValidator;

class LoginController
{

    private $request;
    private $response;
    private $loginValidate;
    private $generateAccToken;
    private $generateRefToken;

    public function __construct(GenerateTokenService $generateAccToken, RefGenerateTokenService $generateRefToken, LoginValidator $loginValidate, JsonResponse $response, Request $request)
    {
        $this->generateRefToken = $generateRefToken;
        $this->generateAccToken = $generateAccToken;
        $this->loginValidate = $loginValidate;
        $this->request = $request;
        $this->response = $response;
    }

    public function login(){
        $request = $this->request->getRequest();
        $data = $request['data'];
        $name =  $data['name'];
        $password = $data['password'];


        try{
            $isLogin =$this->loginValidate->loginValidate($name, $password);
            if($isLogin){
                $acc = $this->generateAccToken->generateAccToken($name);
                $ref = $this->generateRefToken->generateRefToken($name);
                $header = ['Acc' => $acc['acc'], 'Ref' => $ref['ref']];
                return $this->response->sendResponse($isLogin['messages'], 200, $header);
            }
        }catch (\Exception $e){
            return $this->response->sendError($e->getMessage(), 400);
        }
    }


}