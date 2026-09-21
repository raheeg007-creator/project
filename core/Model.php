<?php

require_once __DIR__ . '/../config/database.php';

// الكلاس الأساسي لجميع الموديلز (يرث منه User, Photo, Comment)
abstract class Model
{
    // كائن الـ PDO المتاح لجميع الكلاسات الفرعية
    protected PDO $db;

    public function __construct()
    {
        // جلب الاتصال من كلاس قاعدة البيانات بنمط Singleton
        $this->db = Database::getInstance()->getConnection();
    }
}