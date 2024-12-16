<?php


namespace App\Service\WorkWithJson;

header("Content-Type: application/json; charset=UTF-8");

class Request
{
    public function getRequest()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON format']);
            exit;
        }

        $headers = getallheaders();
        $token = null;
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(' ', $authHeader);

            if (count($arr) === 2 && $arr[0] === 'Bearer') {
                $token = $arr[1];
            }
        }

        return [
            'url' => $uri,
            'method' => $method,
            'data' => $data,
            'headers' => $headers,
            'token' => $token
        ];
    }
}

