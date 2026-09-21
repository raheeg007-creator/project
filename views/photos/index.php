<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Alzikrayat</title>
    <link href="/project/public/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        .photo-card img { height: 220px; object-fit: cover; width: 100%; }
        .list-style img { height: 150px; }

        /* Tablet adjustments */
        @media (max-width: 768px) {
            .photo-card img { height: 180px; }
        }

        /* Mobile phone adjustments */
        @media (max-width: 576px) {
            .photo-card img { height: 160px; }
            .btn-group-sm .btn { font-size: 0.75rem; padding: 0.25rem 0.5rem; }
            .navbar .btn-sm { font-size: 0.75rem; }
        }

        /* Landscape orientation on small devices */
        @media (max-width: 768px) and (orientation: landscape) {
            .photo-card img { height: 140px; }
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4" dir="ltr">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="navbar-brand fw-bold mb-0" href="/project/public/">Alzikrayat</a>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted" style="margin-right: 0.5rem;">Hi <?= htmlspecialchars($_SESSION['first_name']) ?></span>
            <a href="/project/public/photos/create" class="btn btn-primary btn-sm">Upload photo</a>
            <a href="/project/public/logout" class="btn btn-outline-danger btn-sm">Log out</a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- شريط أدوات المعرض: البحث السريع + أزرار تغيير نمط العرض -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3" dir="ltr">
        <div style="max-width: 250px;">
            <input type="text" id="gallerySearch" class="form-control form-control-sm" placeholder="🔍 Search by title or author..." onkeyup="filterGallery()">
        </div>
        <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary" onclick="setGrid(3)">3 columns</button>
            <button class="btn btn-outline-secondary" onclick="setGrid(4)">4 columns</button>
            <button class="btn btn-outline-secondary" onclick="setGrid('list')">list</button>
        </div>
    </div>

    <?php if (empty($photos)): ?>
        <p class="text-center text-muted mt-5">No photos available yet. Be the first to upload a photo!</p>
    <?php else: ?>
        <div class="row g-3" id="gallery">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4 gallery-item">
                    <div class="card photo-card shadow-sm h-100">
                        <img src="/project/public/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>">
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($photo['title']) ?></h6>
                            <p class="text-muted small mb-1">
                                By <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
                            </p>
                            <a href="/project/public/photo/<?= (int) $photo['id'] ?>" class="btn btn-sm btn-outline-primary">View details </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // تغيير نمط العرض (3 أعمدة، 4 أعمدة، قائمة كاملة)
    function setGrid(mode) {
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            item.className = 'gallery-item ' +
                (mode === 'list' ? 'col-12 list-style' : (mode === 4 ? 'col-md-3' : 'col-md-4'));
        });
    }

    // فلترة وبحث سريع وتفاعلي في المعرض بدون إعادة تحميل الصفحة
    function filterGallery() {
        const query = document.getElementById('gallerySearch').value.toLowerCase();
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            const cardText = item.innerText.toLowerCase();
            item.style.display = cardText.includes(query) ? '' : 'none';
        });
    }
</script>

</body>
</html>