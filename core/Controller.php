<?php


abstract class Controller
{
    
    protected const BASE_PATH = '/project/public';

    
    protected function view($view, $data = [])
    {
        $viewPath = dirname(__DIR__) . '/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: " . htmlspecialchars($viewPath));
        }

        extract($data);

        require $viewPath;
    }

    
    protected function redirect($path)
    {
        header("Location: " . self::BASE_PATH . $path);
        exit();
    }

    
    protected function isMethod($method)
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($method);
    }
}