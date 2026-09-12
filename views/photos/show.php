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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/project/public/">📸 Alzikrayat</a>
        <a href="/project/public/photos" class="btn btn-outline-secondary btn-sm">رجوع للمعرض</a>
    </div>
</nav>

<div class="container" style="max-width: 700px;">
    <div class="card shadow-sm mb-4">
        <img src="/project/public/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>" class="card-img-top">
        <div class="card-body">
            <h4><?= htmlspecialchars($photo['title']) ?></h4>
            <p class="text-muted small">
                بواسطة <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
                — <?= htmlspecialchars($photo['date_time']) ?>
            </p>
            <p><?= nl2br(htmlspecialchars($photo['description'])) ?></p>

            <?php if ((int) $photo['user_id'] === (int) $_SESSION['user_id']): ?>
                <a href="/project/public/photo/<?= (int) $photo['id'] ?>/delete"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('هل أنتِ متأكدة من حذف هذه الصورة؟');">
                    حذف الصورة
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== التعليقات ===== -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">التعليقات</h5>

            <form method="POST" action="/project/public/photo/<?= (int) $photo['id'] ?>/comment" class="mb-4">
                <div class="input-group">
                    <input type="text" name="comment" class="form-control" placeholder="اكتبي تعليقاً..." required maxlength="500">
                    <button class="btn btn-primary" type="submit">إرسال</button>
                </div>
            </form>

            <div id="comments-list">
                <?php if (empty($comments)): ?>
                    <p class="text-muted small">لا توجد تعليقات بعد. كوني أول من يعلّق!</p>
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

</body>
</html>