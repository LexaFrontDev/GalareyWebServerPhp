<?php


namespace App\Service\ImagesService;

use App\Command\CurlCommand\CurlCommand;
use App\Service\WorkWithJson\Request;
use App\Service\JwtService\JwtService;
use App\Command\InsertCommand\InsertImagesCommand;

class UploadImageServise extends JwtService
{
    private $curlCommand;
    private $request;
    private $insertImagesCommand;

    public function __construct(InsertImagesCommand $insertImagesCommand,Request $request, CurlCommand $curlCommand)
    {
        $this->insertImagesCommand = $insertImagesCommand;
        $this->request = $request;
        $this->curlCommand = $curlCommand;
    }

    public function upload($file)
    {
        $request = $this->request->getRequest();
        $accToken = $request['token'];


        $decoded = $this->accDecode($accToken, true);


        $client_id = '8b1f3fa9e6c2318cc12aa0d6206a9170a28bf934';
        $url = 'https://api.imgur.com/3/image';

        $postData = [
            'image' => $file
        ];

        $headers = [
            "Accept: application/json'",
            "Authorization: Bearer $client_id"
        ];

        $curl = $this->curlCommand->curlPost($url, $postData, $headers);

        if(!$curl){
            throw new \Exception('Не получилось сохранить изображение в storage');
        }

        if($decoded){
            $data = $decoded['data'];
            $id_users = $data['id'];
            $link = $curl['data']['link'];
            $this->insertImagesCommand->insertImages($link, $id_users);
        }

        return ['messages' => 'Изображение успешно отправленно', 'curl' => $curl];
    }
}
