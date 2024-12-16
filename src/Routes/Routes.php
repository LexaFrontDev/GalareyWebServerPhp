<?php

namespace App\Routes;

use App\Controller\AuthControllerDirectory\LoginController;
use App\Controller\AuthControllerDirectory\RegisterController;
use App\Controller\RefTokenController\UpdateAccToken;
use App\Service\WorkWithJson\JsonResponse;

class Routes
{
    public function routes($container, $url, $method)
    {
        $response = $container->get(JsonResponse::class);

        if ($url === '/register' && $method === 'POST') {
            $registerController = $container->get(RegisterController::class);
            $registerController->register();
            return;
        }

        if ($url === '/login' && $method === 'POST') {
            $LoginController = $container->get(LoginController::class);
            $LoginController->login();
            return;
        }

        if ($url === '/acc' && $method === 'PUT') {
            $updateAccTokenController = $container->get(UpdateAccToken::class);
            $updateAccTokenController->updateTokenController();
            return;
        }



        $response->sendError('Invalid request method or URL.', 404);
    }
}
