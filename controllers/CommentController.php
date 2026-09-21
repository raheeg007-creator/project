<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';


class CommentController extends Controller
{
    /**
    
     *
     * @param int $photoId The photo id from the route parameter.
     */
    public function store($photoId): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $text = trim($_POST['comment'] ?? '');

        if ($text !== '') {
            $commentModel = new \Comment();
            $commentModel->create((int) $photoId, (int) $_SESSION['user_id'], $text);
        }

        $this->redirect('/photo/' . (int) $photoId);
    }
}