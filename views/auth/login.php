<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Login - Alzikrayat</title>
<link href="/project/public/css/bootstrap.rtl.min.css" rel="stylesheet"></head>
<body class="bg-light">

<div class="container" style="max-width: 420px; margin-top: 80px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Login</h3>

            <?php if (!empty($lastLogin)): ?>
                <div class="alert alert-info small">
                          Last login on this device: <?= htmlspecialchars($lastLogin) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

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

            <p class="text-center mt-3 small">
                  Don't have an account? <a href="/project/public/register"> Register now</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>