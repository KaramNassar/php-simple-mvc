<?php

declare(strict_types=1);

namespace App\Core;

/**
 * @property-read ?array $db
 */

class Config
{

    protected array $config;

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST'],
                'database' => $env['DB_DATABASE'],
                'username' => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD'],
                'driver'   => $env['DB_CONNECTION'] ?? 'mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }

}