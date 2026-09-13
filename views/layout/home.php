<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alzikrayat - شارك ذكرياتك</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(135deg, #4a6fa5, #6a89b8);
            color: white;
            padding: 80px 20px;
        }
        .stat-card {
            border: none;
            border-radius: 12px;
        }

        /* Tablet adjustments */
        @media (max-width: 768px) {
            .hero { padding: 60px 20px; }
            .hero h1 { font-size: 2.1rem; }
        }

        /* Mobile phone adjustments */
        @media (max-width: 576px) {
            .hero { padding: 50px 15px; }
            .hero h1 { font-size: 1.8rem; }
            .hero p.lead { font-size: 1rem; }
            .stat-card h2 { font-size: 1.5rem; }
        }

        /* Landscape orientation on small devices */
        @media (max-width: 768px) and (orientation: landscape) {
            .hero { padding: 30px 15px; }
        }
    </style>
</head>
<body>

<!-- ===== Navbar ديناميكي ===== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/project/public/">📸 Alzikrayat</a>

        <div class="collapse navbar-collapse justify-content-between">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/project/public/">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="/project/public/photos">المعرض</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">من نحن</a></li>
            </ul>

            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item d-flex align-items-center me-2">
                        <span class="text-muted">Hi <?= htmlspecialchars($_SESSION['first_name']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger btn-sm" href="/project/public/logout">تسجيل الخروج</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="/project/public/login">Please Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== Hero Section ===== -->
<section class="hero text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">شارك ذكرياتك مع من تحب</h1>
        <p class="lead mb-4">
            Alzikrayat منصة بسيطة لرفع صورك، مشاركتها، والتفاعل معها من خلال التعليقات —
            كل لحظة تستاهل تتحفظ.
        </p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/project/public/photos/create" class="btn btn-light btn-lg">ارفعي صورة الآن</a>
        <?php else: ?>
            <a href="/project/public/register" class="btn btn-light btn-lg">ابدئي الآن مجاناً</a>
        <?php endif; ?>
    </div>
</section>

<!-- ===== إحصائيات ===== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-4">
                    <h2 class="fw-bold text-primary">1000+</h2>
                    <p class="text-muted mb-0">صورة مرفوعة</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-4">
                    <h2 class="fw-bold text-primary">300+</h2>
                    <p class="text-muted mb-0">مستخدم نشط</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-4">
                    <h2 class="fw-bold text-primary">2000+</h2>
                    <p class="text-muted mb-0">تعليق وتفاعل</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== About Us ===== -->
<section id="about" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">من نحن</h2>
        <p class="text-center text-muted" style="max-width: 700px; margin: 0 auto;">
            Alzikrayat مشروع أُنشئ كجزء من مادة تقنيات الويب المتقدمة في جامعة السودان
            للعلوم والتكنولوجيا، بهدف بناء تطبيق ويب متكامل من الصفر باستخدام معمارية
            MVC و3-Tier، بدون الاعتماد على أي إطار عمل خارجي. الهدف هو مشاركة الذكريات
            الجميلة بطريقة بسيطة وآمنة.
        </p>
    </div>
</section>

<!-- ===== Footer ===== -->
<footer class="bg-dark text-white text-center py-3">
    <p class="mb-0 small">© <?= date('Y') ?> Alzikrayat </p>
</footer>

</body>
</html>