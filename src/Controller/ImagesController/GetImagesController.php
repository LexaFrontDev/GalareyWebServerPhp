<?php


namespace App\Controller\ImagesController;


use App\Service\WorkWithJson\JsonResponse;
use App\Service\ImagesService\UploadImageServise;
use App\Service\Roles\RouteRoles;

class GetImagesController{


    private $jsonResponse;
    private $uploadImagesService;
    private $routeRoles;


    public function __construct(RouteRoles $routeRoles,UploadImageServise $uploadImagesService, JsonResponse $jsonResponse){
        $this->routeRoles = $routeRoles;
        $this->uploadImagesService = $uploadImagesService;
        $this->jsonResponse = $jsonResponse;
    }




    public function getImages(){
        $checkRoles = $this->routeRoles->onlyUsers();

        try{




        }catch (\Exception $e){

        }



    }

}