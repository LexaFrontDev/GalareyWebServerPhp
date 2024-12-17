<?php

namespace App\Controller\ImagesController;

use App\Service\WorkWithJson\JsonResponse;
use App\Service\ImagesService\UploadImageServise;
use App\Service\Roles\RouteRoles;

class UploadImagesController
{

    private $jsonResponse;
    private $uploadImagesService;
    private $routeRoles;

    public function __construct(RouteRoles $routeRoles,UploadImageServise $uploadImagesService, JsonResponse $jsonResponse)
    {
        $this->routeRoles = $routeRoles;
        $this->uploadImagesService = $uploadImagesService;
        $this->jsonResponse = $jsonResponse;
    }

    public function uploads(){

        try{
            $checkRoles = $this->routeRoles->onlyUsers();

            if($checkRoles){
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                    $tempPath = $_FILES['image']['tmp_name'];
                    $fileContents = file_get_contents($tempPath);

                    $uploadFile = $this->uploadImagesService->upload($fileContents);
                    return $this->jsonResponse->sendResponse($uploadFile,201);
                }
                return $this->jsonResponse->sendError('Не удалось отправить файл', 404);
            }
        }catch (\Exception $e){
            return $this->jsonResponse->sendError($e->getMessage(), 400);
        }

    }

}

