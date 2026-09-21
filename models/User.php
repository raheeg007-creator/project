<?php

require_once __DIR__ . '/../core/Model.php';

// موديل المستخدم للتعامل مع جدول users في قاعدة البيانات
class User extends Model
{
    // إضافة مستخدم جديد وتشفير كلمة المرور قبل الحفظ
    public function create(string $firstName, string $lastName, string $email, string $password): int
    {
        // تشفير الباسورد بخوارزمية BCRYPT لضمان الأمان
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (first_name, last_name, email, password)
                VALUES (:firstName, :lastName, :email, :password)";

        // استخدام استعلام مجهز (Prepared Statement) للحماية من ثغرات SQL Injection
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName'  => $lastName,
            ':email'     => $email,
            ':password'  => $hashedPassword,
        ]);

        // إرجاع معرف (ID) المستخدم الجديد
        return (int) $this->db->lastInsertId();
    }

    // البحث عن مستخدم بالبريد الإلكتروني (يُستخدم عند تسجيل الدخول أو لمنع تكرار الإيميل)
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // جلب بيانات مستخدم معين باستخدام الـ ID
    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}