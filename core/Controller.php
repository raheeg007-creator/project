<?php

/**
 * Class Controller
 *
 * Abstract base class for all controllers (AuthController, 
 * PhotoController, CommentController). Provides shared helper 
 * methods used across the application, such as loading views 
 * and redirecting the user.
 */
abstract class Controller
{
    /**
     * @var string The base URL path where the application lives.
     * Change this if you move the project to a different folder.
     */
    protected const BASE_PATH = '/project/public';

    /**
     * Loads and renders a view file, optionally passing data to it.
     *
     * @param string $view The view path relative to the views/ folder,
     *                      using dot notation (e.g. 'auth.login' maps
     *                      to views/auth/login.php).
     * @param array  $data Associative array of data to extract into
     *                      variables available inside the view.
     * @return void
     */
    protected function view($view, $data = [])
    {
        $viewPath = dirname(__DIR__) . '/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: " . htmlspecialchars($viewPath));
        }

        extract($data);

        require $viewPath;
    }

    /**
     * Redirects the browser to another path within the application
     * and immediately stops script execution.
     *
     * @param string $path The path to redirect to (e.g. '/login').
     * @return void
     */
    protected function redirect($path)
    {
        header("Location: " . self::BASE_PATH . $path);
        exit();
    }

    /**
     * Returns true only if the current request method matches
     * the expected one. Useful for guarding store/delete actions.
     *
     * @param string $method Expected HTTP method (e.g. 'POST').
     * @return bool
     */
    protected function isMethod($method)
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($method);
    }
}