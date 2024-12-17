<?php

declare(strict_types=1);

namespace App\Command\CurlCommand;

class CurlCommand
{


    public function curlPost(string $url, array $postData, array $headers){

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
            throw new \Exception(['error' => $error]);
        }


        curl_close($ch);


        return json_decode($response, true);
    }


}