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

    private array $entries;

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    private function resolve(string $id)
    {
        $reflectionClass = new ReflectionClass($id);
        if ( ! $reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$id} is not instantiable");
        }

        $constructor       = $reflectionClass->getConstructor();
        $constructorParams = $constructor?->getParameters();

        if ( ! $constructorParams) {
            return new $id();
        }

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

                if ($paramType instanceof ReflectionNamedType
                    && ! $paramType->isBuiltin()
                ) {
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

    public function set(string $id, callable|string $callable): void
    {
        $this->entries[$id] = $callable;
    }

}