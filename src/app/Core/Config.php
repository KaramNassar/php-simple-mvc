<?php

declare(strict_types=1);

namespace App\Core;

/**
 * @property-read ?array $db
 * @property-read ?array $mailer
 */
class Config
{

    protected array $config;

    public function __construct(array $env)
    {
        $this->config = [
            'db'     => [
                'dbname' => $env['DB_DATABASE'],
                'user' => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD'],
                'host'     => $env['DB_HOST'],
                'driver'   => $env['DB_CONNECTION'] ?? 'pdo_mysql',
            ],
            'mailer' => [
                'dsn' => "{$env['MAIL_MAILER']}://{$env['MAIL_HOST']}:{$env['MAIL_PORT']}",
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }

}