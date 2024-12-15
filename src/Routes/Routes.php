<?php

namespace App\Routes;

use App\Controller\AuthControllerDirectory\RegisterController;
use App\Service\WorkWithJson\JsonResponse;

class Routes
{
    public function routes($container, $url, $method)
    {
        $response = $container->get(JsonResponse::class);

        if ($url === '/register' && $method === 'POST') {
            $registerController = $container->get(RegisterController::class);
            $registerController->register();
        } else {
            $response->sendError('Invalid request method or URL.', 404);
        }
    }
}
