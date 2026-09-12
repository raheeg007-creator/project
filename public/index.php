<?php

/**
 * public/index.php
 * نقطة الدخول الوحيدة للتطبيق (Front Controller Pattern).
 * جميع الطلبات تصل إليها عبر .htaccess.
 */

// بدء الجلسة لحالة تسجيل الدخول
session_start();

// تحميل ملف المسارات (الذي ينشئ الـ Router ويشغّل dispatch)
require_once __DIR__ . '/../routes/web.php';