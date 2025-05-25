<?php

namespace Framework\Routing;

class Route
{
    public function __construct(
        protected string $method,
        protected string $path,
        protected mixed $handler,
    ) {}

    public function matches($method, $path): bool
    {
        if (
            $method === $this->method &&
            $path === $this->path
        ) {
            return true;
        }

        return false;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function dispatch(): mixed
    {
        return call_user_func($this->handler);
    }
}
