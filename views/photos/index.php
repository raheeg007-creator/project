<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المعرض - Alzikrayat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        .photo-card img { height: 220px; object-fit: cover; width: 100%; }
        .list-style img { height: 150px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/project/public/">📸 Alzikrayat</a>
        <div class="d-flex align-items-center">
            <span class="text-muted me-3">Hi <?= htmlspecialchars($_SESSION['first_name']) ?></span>
            <a href="/project/public/photos/create" class="btn btn-primary btn-sm me-2">رفع صورة</a>
            <a href="/project/public/logout" class="btn btn-outline-danger btn-sm">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- ===== أزرار اختيار نمط العرض (novelty بسيطة) ===== -->
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary" onclick="setGrid(3)">3 أعمدة</button>
            <button class="btn btn-outline-secondary" onclick="setGrid(4)">4 أعمدة</button>
            <button class="btn btn-outline-secondary" onclick="setGrid('list')">قائمة</button>
        </div>
    </div>

    <?php if (empty($photos)): ?>
        <p class="text-center text-muted mt-5">لا توجد صور بعد. كوني أول من يرفع صورة!</p>
    <?php else: ?>
        <div class="row g-3" id="gallery">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4 gallery-item">
                    <div class="card photo-card shadow-sm h-100">
                        <img src="/project/public/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>">
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($photo['title']) ?></h6>
                            <p class="text-muted small mb-1">
                                بواسطة <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
                            </p>
                            <a href="/project/public/photo/<?= (int) $photo['id'] ?>" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // تبديل نمط العرض بين 3 أعمدة، 4 أعمدة، أو قائمة
    function setGrid(mode) {
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            item.className = 'gallery-item ' +
                (mode === 'list' ? 'col-12 list-style' : (mode === 4 ? 'col-md-3' : 'col-md-4'));
        });
    }
</script>

</body>
</html