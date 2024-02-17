<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\PaymentGatewayInterface;
use App\Exceptions\RouteNotFoundException;
use App\Services\PaddlePayment;

class App
{

    protected static DB $db;

    public function __construct(
        protected Container $container,
        protected Router $router,
        protected array $request,
        protected Config $config
    ) {
        static::$db = new DB($config->db ?? []);

        $this->container->set(
            PaymentGatewayInterface::class,
            PaddlePayment::class
        );
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve(
                $this->request['uri'],
                $this->request['method']
            );
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        }
    }

}