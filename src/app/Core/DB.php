<?php

declare(strict_types=1);

namespace App\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PDOException;
use Throwable;

/**
 * @mixin \Doctrine\DBAL\Connection
 */
class DB
{

    private Connection $connection;

    public function __construct(array $config)
    {
        try {
            $this->connection = DriverManager::getConnection($config);
        } catch (Throwable $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }

}