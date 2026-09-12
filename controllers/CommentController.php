<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';

/**
 * Class CommentController
 *
 * Handles adding comments to photos.
 */
class CommentController extends Controller
{
    /**
     * Stores a new comment for a photo, then redirects back to
     * that photo's detail page. Requires the user to be logged in.
     *
     * @param int $photoId The photo id from the route parameter.
     * @return void
     */
    public function store($photoId): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $text = trim($_POST['comment'] ?? '');

        if ($text !== '') {
            $commentModel = new Comment();
            $commentModel->create((int) $photoId, (int) $_SESSION['user_id'], $text);
        }

        $this->redirect('/photo/' . (int) $photoId);
    }
}