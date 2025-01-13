<?php

namespace App\Service\Functions;

class DumpInfo{


    public static function dumpInfo(...$vars){
        if($vars){
            foreach ($vars as $item){
                echo '<pre>';
                var_dump($item);
                echo '</pre>';
            }
        }
    }
}