<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class Container implements ContainerInterface
{

    private mixed $entries;

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    private function resolve(string $id)
    {
        // 1. Inspect the class that we are trying to get from the container
        $reflectionClass = new ReflectionClass($id);
        if ( ! $reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$id} is not instantiable");
        }

        // 2. Inspect the constructor of the class
        // 3. Inspect the constructor parameters (dependencies)
        $constructor = $reflectionClass->getConstructor();
        $constructorParams = $constructor?->getParameters();

        if ( ! $constructorParams) {
            return new $id();
        }

        // 4. If the constructor parameter is a class try to resolve that class using the container
        $dependencies = array_map(
            function (ReflectionParameter $param) use ($id) {
                $paramName = $param->getName();
                $paramType = $param->getType();

                if ( ! $paramType) {
                    throw new ContainerException(
                        "Failed to resolve class {$id} because param {$paramName} is missing a type hint"
                    );
                }

                if ($paramType instanceof ReflectionUnionType) {
                    throw new ContainerException(
                        "Failed to resolve class {$id} because of union type of param {$paramName}"
                    );
                }

                if($paramType instanceof ReflectionNamedType && ! $paramType->isBuiltin()){
                    return $this->get($paramType->getName());
                }

                throw new ContainerException(
                    "Failed to resolve class {$id} because of invalid param {$paramName}"
                );
            },
            $constructorParams
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function set(string $id, callable $callable): void
    {
        $this->entries[$id] = $callable;
    }

}