<?php

/**
 * Class Router
 *
 * A minimal, hand-written routing engine. Routes are registered with
 * a method, a path pattern (which may contain {param} placeholders),
 * and a [ControllerClass, actionMethod] pair. dispatch() matches the
 * current request against the registered routes using Regular
 * Expressions and calls the matching controller action.
 */
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
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Convert {param} placeholders into a capturing regex group
            $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . rtrim($pattern, '/') . '$#';

            if ($pattern === '#^$#') {
                $pattern = '#^/$#'; // special case for the root path
            }

            if (preg_match($pattern, $requestPath, $matches)) {
                array_shift($matches); // remove the full match, keep only captured params
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
     * Instantiates the matched controller and calls the matched action,
     * passing along any captured route parameters.
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