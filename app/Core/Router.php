<?php

declare(strict_types=1);

/** Routes use named placeholders, for example /san-pham/{slug}. */
final class Router
{
    private array $routes = [];
    private $errorHandler;

    public function __construct(?callable $errorHandler = null)
    {
        $this->errorHandler = $errorHandler;
    }

    public function get(string $path, callable $handler, array $constraints = []): self
    {
        return $this->add('GET', $path, $handler, $constraints);
    }

    public function post(string $path, callable $handler, array $constraints = []): self
    {
        return $this->add('POST', $path, $handler, $constraints);
    }

    private function add(string $method, string $path, callable $handler, array $constraints): self
    {
        if ($path === '' || $path[0] !== '/' || strpbrk($path, '?#') !== false) {
            throw new InvalidArgumentException('Route paths must start with / and contain no query or fragment.');
        }

        $path = rtrim($path, '/') ?: '/';
        $pattern = '';
        $offset = 0;
        $parameters = [];
        preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $path, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $index => [$placeholder, $position]) {
            $name = $matches[1][$index][0];
            if (in_array($name, $parameters, true)) {
                throw new InvalidArgumentException('Duplicate route parameter: ' . $name);
            }
            $pattern .= preg_quote(substr($path, $offset, $position - $offset), '~');
            $constraint = $constraints[$name] ?? '[^/]+';
            $pattern .= '(?P<' . $name . '>' . $constraint . ')';
            $parameters[] = $name;
            $offset = $position + strlen($placeholder);
        }
        $pattern .= preg_quote(substr($path, $offset), '~');
        $pattern = '~^' . $pattern . '$~D';
        if (@preg_match($pattern, '') === false) {
            throw new InvalidArgumentException('Invalid route constraint.');
        }
        $this->routes[] = compact('method', 'pattern', 'parameters', 'handler');

        return $this;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH);
        if (!is_string($path) || $path === '' || $path[0] !== '/') {
            $this->error(404);
            return;
        }
        $path = rtrim($path, '/') ?: '/';
        $allowed = [];
        foreach ($this->routes as $route) {
            if (!preg_match($route['pattern'], $path, $matches)) {
                continue;
            }
            $allowed[] = $route['method'];
            if ($route['method'] === 'GET') {
                $allowed[] = 'HEAD';
            }
            if ($route['method'] !== $method && !($method === 'HEAD' && $route['method'] === 'GET')) {
                continue;
            }
            $arguments = [];
            foreach ($route['parameters'] as $name) {
                $arguments[] = $matches[$name];
            }
            http_response_code(200);
            ($route['handler'])(...$arguments);
            return;
        }

        if ($allowed !== []) {
            $allowed = array_values(array_unique($allowed));
            sort($allowed);
            header('Allow: ' . implode(', ', $allowed));
            $this->error(405);
            return;
        }
        $this->error(404);
    }

    private function error(int $status): void
    {
        http_response_code($status);
        if ($this->errorHandler !== null) {
            ($this->errorHandler)($status);
            return;
        }
        header('Content-Type: text/plain; charset=UTF-8');
        echo $status === 404 ? '404 — Trang không tồn tại' : '405 — Phương thức không được hỗ trợ';
    }
}
