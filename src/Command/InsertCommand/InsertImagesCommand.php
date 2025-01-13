<?php

declare(strict_types=1);

namespace App\Command\InsertCommand;

use App\Command\InsertCommand\InsertCommands;

class InsertImagesCommand extends InsertCommands
{
    public function insertImages($link, $user_id, $title, $description){
        try {
            $pdo =  $this->db->getConnection();
            $pdo->beginTransaction();
            $sql = 'INSERT INTO galarey.images (file_link, id_users) VALUES (:file_link, :id_users)';
            $execute = [
                'file_link' => $link,
                'id_users' => $user_id
            ];
            $idImages = $this->inserts($sql, $execute);

            $sql = 'INSERT INTO galarey.publications (header, description, users, id_images) VALUES (:header, :description, :users, :id_images)';
            $execute = [
                'header' => $title,
                'description' => $description,
                'users' => $user_id,
                'id_images' => $idImages
            ];
            $this->inserts($sql, $execute);
            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw new \Exception("Ошибка при выполнении транзакции: " . $e->getMessage());
        }
    }
}
