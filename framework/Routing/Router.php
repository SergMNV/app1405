<?php

namespace Framework\Routing;

use Exception;

class Router
{
    private array $routes = [];
    private array $errorHandlers = [];
    protected Route $current;

    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $paths = $this->paths();

        $matching = $this->matching($requestMethod, $requestUri);

        if ($matching) {
            $this->current = $matching;

            try {
                return $matching->dispatch();
            } catch (Exception $e) {
                return $this->dispatchServerError();
            }
        }

        if (in_array($requestUri, $paths)) {
            return $this->dispatchNotAllowed();
        }

        return $this->dispatchNotFound();
    }

    public function setErrorHandler(string $alias, mixed $handler): void
    {
        $this->errorHandlers[$alias] = $handler;
    }

    public function addRoute(string $method, string $path, mixed $handler): static
    {
        $this->routes[] = new Route($method, $path, $handler);
        return $this;
    }

    public function redirect(string $path): void
    {
        header("Localhost: /{$path}");
        exit;
    }

    private function matching(string $method, string $uri): ?Route
    {
        foreach ($this->routes as $route) {
            /**
             * @var Route $route
             */
            if ($route->matches($method, $uri)) {
                return $route;
            }
        }

        return null;
    }

    private function paths(): array
    {
        $paths = [];

        foreach ($this->routes as $route) {
            $paths[] = $route->path();
        }

        return $paths;
    }

    private function dispatchNotFound()
    {
        $this->errorHandlers[404] ??= fn() => 'error 404 page not found';
        return $this->errorHandlers[404]();
    }

    private function dispatchNotAllowed()
    {
        $this->errorHandlers[400] ??= fn() => 'error 400 not allowed';
        return $this->errorHandlers[400]();
    }

    private function dispatchServerError()
    {
        $this->errorHandlers[500] ??= fn() => 'error 500 server error';
        return $this->errorHandlers[500]();
    }
}
