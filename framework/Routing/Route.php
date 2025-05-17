<?php

namespace Framework\Routing;

class Route
{
    public function __construct(
        public string $method,
        public string $path,
        public mixed $handler,
    ) {}

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function handler(): mixed
    {
        return $this->handler;
    }
}
