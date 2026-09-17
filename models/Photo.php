<?php

require_once __DIR__ . '/../core/Model.php';


class Photo extends Model
{
    /**
     *
     * @param int    $userId      Owner of the photo.
     * @param string $fileName    Physical file name on disk.
     * @param string $title       Short title of the photo.
     * @param string $description Optional caption/story.
     * @return int The id of the newly created photo.
     */
    public function create(int $userId, string $fileName, string $title, string $description): int
    {
        $sql = "INSERT INTO photos (user_id, file_name, title, description)
                VALUES (:userId, :fileName, :title, :description)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':userId'      => $userId,
            ':fileName'    => $fileName,
            ':title'       => $title,
            ':description' => $description,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     
     * @return array List of photo records.
     */
    public function getAll(): array
    {
        $sql = "SELECT photos.*, users.first_name, users.last_name
                FROM photos
                JOIN users ON photos.user_id = users.id
                ORDER BY photos.date_time DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * @param int $id The photo id.
     * @return array|false
     */
    public function findById(int $id)
    {
        $sql = "SELECT photos.*, users.first_name, users.last_name
                FROM photos
                JOIN users ON photos.user_id = users.id
                WHERE photos.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * @param int $photoId The photo to delete.
     * @param int $userId  The currently logged-in user's id.
     * @return bool True if a row was deleted, false otherwise.
     */
    public function deleteIfOwner(int $photoId, int $userId): bool
    {
        $sql = "DELETE FROM photos WHERE id = :id AND user_id = :userId";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'     => $photoId,
            ':userId' => $userId,
        ]);

        // rowCount() > 0 means a row actually matched and got deleted
        return $stmt->rowCount() > 0;
    }
}