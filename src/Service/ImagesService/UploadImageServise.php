<?php


namespace App\Service\ImageService;


class UploadImageServise
{
    public function upload($file, $nameFile)
    {
        $client_id = '8b1f3fa9e6c2318cc12aa0d6206a9170a28bf934';
        $url = 'https://api.imgur.com/3/image';
        $cfile = new \CURLFile($file, mime_content_type($file), $nameFile);

        $postData = [
            'image' => $cfile
        ];

        $headers = [
            "Authorization: Bearer $client_id"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => $error];
        }


        curl_close($ch);
        return $response;
    }
}
