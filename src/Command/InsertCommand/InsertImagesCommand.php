<?php

declare(strict_types=1);

namespace App\Command\InsertCommand;

use App\Command\InsertCommand\InsertCommands;

class InsertImagesCommand extends InsertCommands
{

    public function insertImages($link, int $idUsers){
        $sql = 'INSERT INTO galarey.images (file_link, id_users) VALUES (:file_link, :id_users)';
        $execute = [
            'file_link' => $link,
            'id_users' => $idUsers
        ];
        $this->inserts($sql, $execute);
    }

}