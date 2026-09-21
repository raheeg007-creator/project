<?php

/**
 * تطبيق نمط التصميم Singleton لكلاس قاعدة البيانات.
 * الهدف: ضمان وجود نسخة واحدة فقط من الاتصال (Single Instance) طوال دورة حياة الطلب لتوفير موارد السيرفر.
 */
class Database
{
    // متغير ستاتيك للاحتفاظ بالنسخة الوحيدة من الكلاس
    private static ?Database $instance = null;

    // كائن اتصال PDO
    private PDO $connection;

    // إعدادات الاتصال بقاعدة البيانات
    private string $host = 'localhost';
    private string $dbName = 'alzikrayat';
    private string $username = 'root';
    private string $password = '';

    // جعل الـ Constructor خاص (private) لمنع إنشاء أي كائن جديد عبر new Database() من الخارج
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";charset=utf8mb4";

            $this->connection = new PDO($dsn, $this->username, $this->password, [
                // رمي استثناءات عند حدوث أي خطأ بدلاً من التجاهل الصامت
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // إرجاع نتائج الاستعلامات كمصفوفة ترابطية بشكل افتراضي
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // استخدام Prepared Statements حقيقية من MySQL للحماية من الـ SQL Injection
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            // إيقاف التنفيذ وعرض رسالة الخطأ عند تعذر الاتصال
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // الدالة المركزية لنمط Singleton: تُرجع النسخة الوحيدة للكلاس أو تنشئها إن لم تكن موجودة
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // إرجاع كائن اتصال الـ PDO من النسخة الحالية
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    // منع استنساخ الكائن باستخدام clone
    private function __clone() {}

    // منع استعادة الكائن عبر unserialize لضمان بقاء النسخة وحيدة دائماً
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}