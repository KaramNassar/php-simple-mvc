<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use Throwable;

/**
 * @mixin PDO
 */
class DB
{

    private PDO $pdo;

    public function __construct(array $config)
    {
        try {
            $defaultOptions = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo      = new PDO(
                $config['driver'] . ':host=' . $config['host']
                . ';dbname='
                . $config['database'],
                $config['username'],
                $config['password'],
                $config['options'] ?? $defaultOptions
            );
        } catch (Throwable $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

}