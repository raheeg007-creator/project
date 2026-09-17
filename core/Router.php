<?php

class Router
{
    /**
     * @var array Holds all registered routes.
     */
    private array $routes = [];

    /**
     * Registers a new route.
     *
     * @param string $method     HTTP method (GET, POST, etc.).
     * @param string $path       Route pattern, e.g. '/photo/{id}'.
     * @param array  $controller [ControllerClassName, actionMethodName].
     * @return void
     */
    public function add(string $method, string $path, array $controller): void
    {
        $this->routes[] = [
            'method'     => strtoupper($method),
            'path'       => $path,
            'controller' => $controller[0],
            'action'     => $controller[1],
        ];
    }

    /**
     * Matches the current request against all registered routes and
     * dispatches to the matching controller action. Sends a 404 view
     * if no route matches.
     *
     * @return void
     */
    public function dispatch(): void
    {
        $requestUri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        // Adjust this if your project folder sits elsewhere under htdocs
        $basePath    = '/project/public';
        $requestPath = substr($requestUri, strlen($basePath));
        $requestPath = '/' . trim($requestPath, '/');

        foreach ($this->routes as $route) {
            // Skip routes registered for a different HTTP method
            // (e.g. a GET route should never match a POST request)
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            
            $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $route['path']);

            
            $pattern = '#^' . rtrim($pattern, '/') . '$#';

            // Special case
            if ($pattern === '#^$#') {
                $pattern = '#^/$#';
            }

            if (preg_match($pattern, $requestPath, $matches)) {
                // $matches[0] is always the full matched string, which we
                // don't need - only the captured groups (the actual param
                // values, e.g. the "25" in "/photo/25") matter here.
                array_shift($matches);

                $this->execute($route, $matches);
                return;
            }
        }

        // No route matched
        http_response_code(404);
        require_once __DIR__ . '/../views/layout/404.php';
        exit;
    }

    /**
     
     *
     * @param array $route  The matched route definition.
     * @param array $params Captured URL parameters (e.g. an id).
     * @return void
     */
    private function execute(array $route, array $params): void
    {
        $controllerClass = $route['controller'];
        $action          = $route['action'];

        if (!class_exists($controllerClass)) {
            require_once __DIR__ . '/../controllers/' . $controllerClass . '.php';
        }

        $instance = new $controllerClass();

        if (!is_callable([$instance, $action])) {
            throw new RuntimeException("Action {$action} not found in {$controllerClass}.");
        }

        $instance->{$action}(...$params);
    }
}
