<?php

require_once __DIR__ . '/../core/Model.php';

// موديل الصور للتعامل مع عمليات رفع، استرجاع، وحذف الصور من قاعدة البيانات
class Photo extends Model
{
    // حفظ بيانات الصورة الجديدة وربطها بالمستخدم الذي رفعها
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

        // إرجاع الـ ID الخاص بالصورة بعد حفظها
        return (int) $this->db->lastInsertId();
    }

    // جلب جميع الصور مع اسم صاحب كل صورة وعرضها من الأحدث للأقدم
    public function getAll(): array
    {
        $sql = "SELECT photos.*, users.first_name, users.last_name
                FROM photos
                JOIN users ON photos.user_id = users.id
                ORDER BY photos.date_time DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // استرجاع تفاصيل صورة محددة مع بيانات صاحبها لعرضها في صفحة الصورة المنفردة
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

    // حذف الصورة بشرط أن يكون المستخدم الحالي هو صاحبها فقط (لحماية خصوصية الصور)
    public function deleteIfOwner(int $photoId, int $userId): bool
    {
        $sql = "DELETE FROM photos WHERE id = :id AND user_id = :userId";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'     => $photoId,
            ':userId' => $userId,
        ]);

        // rowCount > 0 يعني إنه لقى السطر وحذفه فعلاً
        return $stmt->rowCount() > 0;
    }
}