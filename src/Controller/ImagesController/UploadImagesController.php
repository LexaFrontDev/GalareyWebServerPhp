<?php

namespace App\Controller\ImagesController;

use App\Service\WorkWithJson\JsonResponse;
use App\Service\ImageService\UploadImageServise;

class UploadImagesController
{

    private $jsonResponse;
    private $imageServise;

    public function __construct(UploadImageServise $imageServise, JsonResponse $jsonResponse)
    {
        $this->imageServise = $imageServise;
        $this->jsonResponse = $jsonResponse;
    }

    public function uploads(){
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
            $tempPath = $_FILES['file']['tmp_name'];
            $originalName = $_FILES['file']['name'];
            $fileContents = file_get_contents($tempPath);

            $uploadFile = $this->imageServise->upload($fileContents, $originalName);
            return $this->jsonResponse->sendResponse($uploadFile,201);
        }
        return $this->jsonResponse->sendError('Не удалось отправить файл', 404);
    }

}

