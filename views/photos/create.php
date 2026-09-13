<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رفع صورة - Alzikrayat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container" style="max-width: 500px; margin-top: 60px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h4 class="mb-4">رفع صورة جديدة</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/project/public/photos/store" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="title" class="form-control" maxlength="200" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف (اختياري)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">اختاري صورة</label>
                    <input type="file" name="photo" class="form-control" accept="image/png, image/jpeg, image/gif" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">رفع</button>
            </form>

            <a href="/project/public/photos" class="d-block text-center mt-3 small">رجوع للمعرض</a>
        </div>
    </div>
</div>

<script>
    // Client-side JavaScript validation layer for the upload form.
    // Runs before submission to catch obvious problems early, in
    // addition to the HTML5 attributes and server-side checks.
    document.querySelector('form').addEventListener('submit', function (e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const fileInput = document.querySelector('input[name="photo"]');
        const file = fileInput.files[0];

        // Title must not be empty or just whitespace
        if (title === '') {
            e.preventDefault();
            alert('يجب إدخال عنوان للصورة.');
            return;
        }

        // A file must actually be selected
        if (!file) {
            e.preventDefault();
            alert('يجب اختيار صورة.');
            return;
        }

        // Check the file type on the client side too (defense in depth -
        // the real, authoritative check still happens on the server)
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            alert('الملف يجب أن يكون صورة بصيغة jpg أو png أو gif.');
            return;
        }

        // Limit file size to 5MB on the client side to avoid a slow
        // upload attempt that will fail anyway
        const maxSizeBytes = 5 * 1024 * 1024;
        if (file.size > maxSizeBytes) {
            e.preventDefault();
            alert('حجم الصورة يجب ألا يتجاوز 5 ميجابايت.');
        }
    });
</script>

</body>
</html>