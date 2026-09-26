<?php
namespace PresenceEngine\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, $handler, array $middleware): void
    {
        $pattern = preg_replace('#\{([a-z_]+)\}#', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'     => $method,
            'pattern'    => $pattern,
            'handler'    => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;

            if (preg_match($route['pattern'], $uri, $matches)) {
                foreach ($route['middleware'] as $mw) {
                    $instance = new $mw();
                    if ($instance->handle() === false) {
                        return;
                    }
                }

                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $handler = $route['handler'];

                if ($handler instanceof \Closure) {
                    $handler(...array_values($params));
                    return;
                }

                [$controller, $action] = $handler;
                $instance = new $controller();
                $instance->$action(...array_values($params));
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../Views/errors/404.php';
    }
}