<?php
/** 
 * ملف تسجيل جميع مسارات التطبيق (Route Definitions).
 */

require_once __DIR__ . '/../core/Router.php';

$routerClass = 'Router';
$router = new $routerClass();

// ========== مسارات المصادقة (Auth) ==========
$router->add('GET',  '/',                 ['AuthController', 'index']);        // الصفحة الرئيسية
$router->add('GET',  '/login',            ['AuthController', 'showLogin']);    // نموذج تسجيل الدخول
$router->add('POST', '/login',            ['AuthController', 'login']);        // تنفيذ تسجيل الدخول
$router->add('GET',  '/register',         ['AuthController', 'showRegister']); // نموذج التسجيل
$router->add('POST', '/register',         ['AuthController', 'register']);     // تنفيذ التسجيل
$router->add('GET',  '/logout',           ['AuthController', 'logout']);       // تسجيل الخروج

// ========== مسارات الصور (Photos) ==========
$router->add('GET',  '/photos',              ['PhotoController', 'index']);   // معرض الصور
$router->add('GET',  '/photos/create',       ['PhotoController', 'create']);  // نموذج رفع صورة
$router->add('POST', '/photos/store',        ['PhotoController', 'store']);   // حفظ الصورة
$router->add('GET',  '/photo/{id}',          ['PhotoController', 'show']);    // عرض صورة واحدة
$router->add('GET',  '/photo/{id}/delete',   ['PhotoController', 'delete']);  // حذف صورة

// ========== مسارات التعليقات (Comments) ==========
$router->add('POST', '/photo/{id}/comment', ['CommentController', 'store']);  // إضافة تعليق

// تشغيل الـ Router لمطابقة الطلب الحالي
$router->dispatch();