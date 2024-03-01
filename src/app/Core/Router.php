<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Attributes\Route;
use App\Exceptions\RouteNotFoundException;
use ReflectionAttribute;
use ReflectionClass;

class Router
{

    private array $routes = [];

    public function __construct(private readonly Container $container)
    {
    }

    public function post(string $route, callable|array $action): static
    {
        $this->register('POST', $route, $action);

        return $this;
    }

    public function register(
        string $method,
        string $route,
        callable|array $action
    ): static {
        $this->routes[$method][$route] = $action;

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
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

    public function get(string $route, callable|array $action): static
    {
        $this->register('GET', $route, $action);

        return $this;
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function registerRoutesFromControllerAttributes(array $controllers)
    {
        foreach ($controllers as $controller) {
            $reflectionController = new ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(
                    Route::class,
                    ReflectionAttribute::IS_INSTANCEOF
                );

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register(
                        $route->method->value,
                        $route->path,
                        [$controller, $method->getName()]
                    );
                }
            }
        }
    }

}