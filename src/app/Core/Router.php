<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\RouteNotFoundException;

class Router
{

    private array $routes = [];

    public function get(string $route, callable|array $action): static
    {
        $this->register('GET', $route, $action);

        return $this;
    }

    public function register(
        string         $method,
        string         $route,
        callable|array $action
    ): static {
        $this->routes[$method][$route] = $action;

        return $this;
    }

    public function post(string $route, callable|array $action): static
    {
        $this->register('POST', $route, $action);

        return $this;
    }

    public function resolve(string $requestUrl, string $requestMethod)
    {
        $requestUrl = explode('?', $requestUrl)[0];
        $action     = $this->routes[$requestMethod][$requestUrl] ?? null;

        if ( ! $action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = new $class();

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

}