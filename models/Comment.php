<?php

require_once __DIR__ . '/../core/Model.php';


class Comment extends Model
{
    /**     
     * @param int    $photoId The photo being commented on.
     * @param int    $userId  The author of the comment.
     * @param string $text    The comment content.
     * @return int The id of the newly created comment.
     */
    public function create(int $photoId, int $userId, string $text): int
    {
        $sql = "INSERT INTO comments (photo_id, user_id, comment)
                VALUES (:photoId, :userId, :comment)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':photoId' => $photoId,
            ':userId'  => $userId,
            ':comment' => $text,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     
     *
     * @param int $photoId The photo id.
     * @return array List of comment records.
     */
    public function getByPhotoId(int $photoId): array
    {
        $sql = "SELECT comments.*, users.first_name, users.last_name
                FROM comments
                JOIN users ON comments.user_id = users.id
                WHERE comments.photo_id = :photoId
                ORDER BY comments.date_time ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':photoId' => $photoId]);
        return $stmt->fetchAll();
    }
}