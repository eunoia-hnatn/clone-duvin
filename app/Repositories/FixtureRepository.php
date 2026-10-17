<?php

declare(strict_types=1);

abstract class FixtureRepository
{
    private string $directory;
    private array $cache = [];

    public function __construct(?string $directory = null)
    {
        $this->directory = $directory ?? dirname(__DIR__, 2) . '/database/fixtures';
    }

    protected function load(string $name): array
    {
        if (!preg_match('/^[a-z_]+$/D', $name)) {
            throw new InvalidArgumentException('Invalid fixture name.');
        }
        if (!array_key_exists($name, $this->cache)) {
            $file = $this->directory . '/' . $name . '.php';
            if (!is_file($file)) {
                throw new RuntimeException('Fixture not found: ' . $name);
            }
            $data = (static function (string $file) { return require $file; })($file);
            if (!is_array($data)) {
                throw new UnexpectedValueException('Fixture must return an array: ' . $name);
            }
            $this->cache[$name] = $data;
        }
        return $this->cache[$name];
    }
}
