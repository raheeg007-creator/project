<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Login - Alzikrayat</title>
    <!-- استدعاء ملف تنسيقات Bootstrap لدعم الاتجاه من اليمين لليسار (RTL) -->
    <link href="/project/public/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- صندوق نموذج تسجيل الدخول في منتصف الصفحة -->
<div class="container" style="max-width: 420px; margin-top: 80px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Login</h3>

            <!-- إظهار تاريخ آخر تسجيل دخول لو محفوظ في الكوكيز -->
            <?php if (!empty($lastLogin)): ?>
                <div class="alert alert-info small">
                          Last login on this device: <?= htmlspecialchars($lastLogin) ?>
                </div>
            <?php endif; ?>

            <!-- إظهار رسالة الخطأ لو بيانات الدخول غير صحيحة -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- فورم تسجيل الدخول وإرسال البيانات عبر POST -->
            <form method="POST" action="/project/public/login" novalidate>
                <div class="mb-3">
                    <label class="form-label">Email </label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"> password</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- رابط لصفحة إنشاء حساب جديد لو المستخدم ليس لديه حساب -->
            <p class="text-center mt-3 small">
                  Don't have an account? <a href="/project/public/register"> Register now</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>