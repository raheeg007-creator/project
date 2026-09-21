<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';


class PhotoController extends Controller
{
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = dirname(__DIR__) . '/public/images/uploads/';
    }

    public function index(): void
    {
        $this->requireLogin();

        $photoModel = new Photo();
        $photos = $photoModel->getAll();

        $this->view('photos.index', ['photos' => $photos]);
    }

    
    public function create(): void
    {
        $this->requireLogin();
        $this->view('photos.create', ['error' => null]);
    }

    
    public function store(): void
    {
        $this->requireLogin();

        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            $this->view('photos.create', ['error' => 'Please enter a title for the image.']);
            return;
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->view('photos.create', ['error' => 'Please select a valid image.']);
            return;
        }

        
        $maxSizeBytes = 5 * 1024 * 1024;
        if ($_FILES['photo']['size'] > $maxSizeBytes) {
            $this->view('photos.create', ['error' => 'The image size must not exceed 5 MB.']);
            return;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['photo']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $this->view('photos.create', ['error' => 'The file must be an image (jpg, png, gif).']);
            return;
        
        }

        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fileName  = uniqid('photo_', true) . '.' . $extension;
        $destination = $this->uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            $this->view('photos.create', ['error' => 'An error occurred while uploading the image.']);
            return;
        }

        $photoModel = new Photo();
        $photoModel->create($_SESSION['user_id'], $fileName, $title, $description);

        $this->redirect('/photos');
    }

    
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

        $commentModel = new Comment();
        $comments = $commentModel->getByPhotoId((int) $id);

        $this->view('photos.show', ['photo' => $photo, 'comments' => $comments]);
    }

    
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
    
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}