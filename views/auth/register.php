<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Register - Alzikrayat</title>
<link href="/project/public/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container" style="max-width: 480px; margin-top: 60px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Register</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/project/public/register" novalidate>
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control"
                           pattern="[A-Za-z]{1,50}" maxlength="50" required
                           title="English letters only, no numbers or symbols">
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control"
                           pattern="[A-Za-z]{1,50}" maxlength="50" required
                           title="English letters only, no numbers or symbols">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                           required minlength="6">
                    <div class="form-text">6 characters at least</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <p class="text-center mt-3 small">
                Already have an account? <a href="/project/public/login">Login here</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Client-side JavaScript validation layer (طبقة تحقق إضافية غير HTML5)
    document.querySelector('form').addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        if (password.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters.');
        }
    });
</script>

</body>
</html>