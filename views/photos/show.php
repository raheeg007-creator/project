<?php
$photo = $photo ?? [
    'id' => 0,
    'title' => '',
    'file_name' => '',
    'first_name' => '',
    'last_name' => '',
    'date_time' => '',
    'description' => '',
    'user_id' => 0,
];
$comments = $comments ?? [];
$currentUserId = $_SESSION['user_id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($photo['title']) ?> - Alzikrayat</title>
<link href="/project/public/css/bootstrap.rtl.min.css" rel="stylesheet">    <style>
        @media (max-width: 576px) {
            .card-img-top { max-height: 300px; object-fit: cover; }
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4" dir="ltr">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="navbar-brand fw-bold mb-0" href="/project/public/">Alzikrayat</a>
        <a href="/project/public/photos" class="btn btn-outline-secondary btn-sm">Return to Gallery</a>
    </div>
</nav>

<div class="container" style="max-width: 700px;">
    <div class="card shadow-sm mb-4">
        <img id="mainPhoto" src="/project/public/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" class="card-img-top" style="transition: filter 0.3s ease;">
        
        <!-- ميزة إضافية للتميز (Novelty Feature): خوارزميات فلاتر تفاعلية للصور -->
        <div class="p-3 border-bottom bg-light d-flex align-items-center justify-content-between flex-wrap gap-2">
            <span class="small text-muted fw-bold"> Image Filters:</span>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active" onclick="applyFilter('none', this)">Normal</button>
                <button type="button" class="btn btn-outline-secondary" onclick="applyFilter('grayscale(100%)', this)">B&W</button>
                <button type="button" class="btn btn-outline-secondary" onclick="applyFilter('sepia(85%)', this)">Sepia</button>
                <button type="button" class="btn btn-outline-secondary" onclick="applyFilter('contrast(130%) saturate(140%)', this)">Vivid</button>
                <button type="button" class="btn btn-outline-secondary" onclick="applyFilter('sepia(40%) hue-rotate(315deg) contrast(110%)', this)">Vintage</button>
            </div>
        </div>

        <div class="card-body">
            <h4><?= htmlspecialchars($photo['title']) ?></h4>
            <p class="text-muted small">
                By <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
                — <?= htmlspecialchars($photo['date_time']) ?>
            </p>
            <p><?= nl2br(htmlspecialchars($photo['description'])) ?></p>

            <?php if ((int) $photo['user_id'] === (int) $_SESSION['user_id']): ?>
                <a href="/project/public/photo/<?= (int) $photo['id'] ?>/delete"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this image?');">
                    Delete Image
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== التعليقات ===== -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Comments</h5>

            <form method="POST" action="/project/public/photo/<?= (int) $photo['id'] ?>/comment" class="mb-4">
                <div class="input-group">
                    <input type="text" name="comment" class="form-control" placeholder="Write a comment..." required maxlength="500">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>

            <div id="comments-list">
                <?php if (empty($comments)): ?>
                    <p class="text-muted small">No comments yet. Be the first to comment!</p>
                <?php else: ?>
                    <?php foreach ($comments as $c): ?>
                        <div class="border-bottom py-2">
                            <strong><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></strong>
                            <span class="text-muted small">— <?= htmlspecialchars($c['date_time']) ?></span>
                            <p class="mb-0"><?= htmlspecialchars($c['comment']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. طبقة التحقق عبر JavaScript للتعليقات (Layer 2 Client-side Validation)
    const commentForm = document.querySelector('form');
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            const input = this.querySelector('input[name="comment"]');
            if (!input || input.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a non-empty comment.');
                if (input) input.focus();
            }
        });
    }

    // 2. تطبيق خوارزميات فلاتر الصور التفاعلية (Novelty Task: Custom Image Filters)
    function applyFilter(filterCss, btn) {
        const img = document.getElementById('mainPhoto');
        if (img) {
            img.style.filter = filterCss;
        }
        const buttons = btn.parentElement.querySelectorAll('button');
        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }
</script>

</body>
</html>