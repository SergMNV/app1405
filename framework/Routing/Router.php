<?php

namespace Framework\Routing;

class Router
{
    public array $routes = [];
    public array $errorHandlers = [];

    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $matching = $this->matching($requestMethod, $requestUri);

        if ($matching) {
            return call_user_func($matching->handler());
        } else {
            return $this->dispatchNotFound();
            //include __DIR__ . '../../resources/views/includes/404.php';
        }

        exit;
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

    private function matching(string $method, string $uri): ?Route
    {
        foreach ($this->routes as $route) {
            /**
             * @var Route $route
             */
            if ($route->method() === $method && $route->path() == $uri) {
                return $route;
            }
        }

        return null;
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
