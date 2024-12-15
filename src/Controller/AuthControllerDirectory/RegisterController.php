<?php

namespace App\Controller\AuthControllerDirectory;


use App\Model\DatabaseConfig\DatabaseConnect;
use App\Service\WorkWithJson\Request;
use App\Service\WorkWithJson\JsonResponse;

class RegisterController
{

    private $database;
    private $request;
    private $response;

    public function __construct(JsonResponse $response,Request $request,DatabaseConnect $database)
    {
        $this->request = $request;
        $this->database = $database;
        $this->response = $response;
    }


    public function register(){
        $request = $this->request->getRequest();
            $data = $request['data'];
            $name =  $data['name'];
            $email = $data['email'];

            $responseData = ['name' => $name, 'email' => $email];
            return $this->response->sendResponse($responseData, 201);
    }

}