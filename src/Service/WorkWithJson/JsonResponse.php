<?php



namespace App\Service\WorkWithJson;

header("Content-Type: application/json; charset=UTF-8");

class JsonResponse
{
    public function sendResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        echo json_encode($data);
    }

    public function sendError($data, $statusCode = 200){
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
