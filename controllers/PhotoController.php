<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';

/**
 * Class PhotoController
 *
 * Handles the photo gallery, uploading, viewing details, and
 * deleting photos with ownership validation.
 */
class PhotoController extends Controller
{
    /**
     * @var string Absolute path to the uploads directory on disk.
     */
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = dirname(__DIR__) . '/public/images/uploads/';
    }

    /**
     * Displays the photo gallery (all photos, most recent first).
     * Requires the user to be logged in.
     *
     * @return void
     */
    public function index(): void
    {
        $this->requireLogin();

        $photoModel = new Photo();
        $photos = $photoModel->getAll();

        $this->view('photos.index', ['photos' => $photos]);
    }

    /**
     * Displays the upload form. Requires login.
     *
     * @return void
     */
    public function create(): void
    {
        $this->requireLogin();
        $this->view('photos.create', ['error' => null]);
    }

    /**
     * Processes the upload form: validates the image, moves it to
     * public/images/uploads/, and saves its metadata to the database.
     *
     * @return void
     */
    public function store(): void
    {
        $this->requireLogin();

        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            $this->view('photos.create', ['error' => 'يجب إدخال عنوان للصورة.']);
            return;
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->view('photos.create', ['error' => 'يجب اختيار صورة صحيحة.']);
            return;
        }

        // Enforce a 5MB max size on the server side. This is the
        // authoritative check - the JavaScript check on the client
        // only improves user experience and can be bypassed.
        $maxSizeBytes = 5 * 1024 * 1024;
        if ($_FILES['photo']['size'] > $maxSizeBytes) {
            $this->view('photos.create', ['error' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.']);
            return;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['photo']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $this->view('photos.create', ['error' => 'الملف يجب أن يكون صورة (jpg, png, gif).']);
            return;
        
        }

        // Generate a unique file name to prevent overwriting existing files
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fileName  = uniqid('photo_', true) . '.' . $extension;
        $destination = $this->uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            $this->view('photos.create', ['error' => 'حدث خطأ أثناء رفع الصورة.']);
            return;
        }

        $photoModel = new Photo();
        $photoModel->create($_SESSION['user_id'], $fileName, $title, $description);

        $this->redirect('/photos');
    }

    /**
     * Displays a single photo with its full metadata and comments.
     *
     * @param int $id The photo id from the route parameter.
     * @return void
     */
    public function show($id): void
    {
        $this->requireLogin();

        $photoModel = new Photo();
        $photo = $photoModel->findById((int) $id);

        if (!$photo) {
            http_response_code(404);
            require_once dirname(__DIR__) . '/views/layout/404.php';
            exit;
        }

        require_once __DIR__ . '/../models/Comment.php';
        $commentModel = new Comment();
        $comments = $commentModel->getByPhotoId((int) $id);

        $this->view('photos.show', ['photo' => $photo, 'comments' => $comments]);
    }

    /**
     * Deletes a photo, but only if the current user owns it.
     * Also removes the physical file from disk.
     *
     * @param int $id The photo id from the route parameter.
     * @return void
     */
    public function delete($id): void
    {
        $this->requireLogin();

        $photoModel = new Photo();
        $photo = $photoModel->findById((int) $id);

        if ($photo && (int) $photo['user_id'] === (int) $_SESSION['user_id']) {
            $filePath = $this->uploadDir . $photo['file_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $photoModel->deleteIfOwner((int) $id, (int) $_SESSION['user_id']);
        }

        $this->redirect('/photos');
    }
    /**
     * Guards an action so it can only run if the user is logged in.
     * Redirects to the login page otherwise.
     *
     * @return void
     */
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}