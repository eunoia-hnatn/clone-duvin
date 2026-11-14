<?php

declare(strict_types=1);

final class Request
{
    private array $get;
    private array $post;
    private array $server;
    private ?array $json = null;

    public function __construct(?array $get = null, ?array $post = null, ?array $server = null)
    {
        $this->get = $get ?? $_GET;
        $this->post = $post ?? $_POST;
        $this->server = $server ?? $_SERVER;
    }

    public static function createFromGlobals(): self
    {
        return new self();
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function path(): string
    {
        $path = parse_url($this->uri(), PHP_URL_PATH);
        if (!is_string($path) || $path === '') {
            return '/';
        }
        return rtrim($path, '/') ?: '/';
    }

    public function query(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->get;
        }
        return $this->get[$key] ?? $default;
    }

    public function post(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? $default;
    }

    public function json(?string $key = null, mixed $default = null): mixed
    {
        if ($this->json === null) {
            $input = file_get_contents('php://input');
            if (is_string($input) && $input !== '') {
                $decoded = json_decode($input, true);
                $this->json = is_array($decoded) ? $decoded : [];
            } else {
                $this->json = [];
            }
        }

        if ($key === null) {
            return $this->json;
        }
        return $this->json[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post, $this->json());
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function isAjax(): bool
    {
        return strtolower($this->server['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
    }

    public function header(string $key, mixed $default = null): mixed
    {
        $name = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$name] ?? $default;
    }

    public function ip(): string
    {
        return $this->server['HTTP_CF_CONNECTING_IP']
            ?? $this->server['HTTP_X_FORWARDED_FOR']
            ?? $this->server['REMOTE_ADDR']
            ?? '127.0.0.1';
    }
}

