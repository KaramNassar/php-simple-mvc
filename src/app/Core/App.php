<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\PaymentGatewayInterface;
use App\Exceptions\RouteNotFoundException;
use App\Services\CustomMailer;
use App\Services\PaddlePayment;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Symfony\Component\Mailer\MailerInterface;

class App
{

    protected static DB $db;
    protected static EntityManager $entityManager;
    protected Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = []
    ) {
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public static function entityManager(): EntityManager
    {
        return static::$entityManager;
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

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/..');
        $dotenv->load();

        $this->config = new Config($_ENV);

        static::$db = new DB($this->config->db ?? []);

        $this->container->set(
            PaymentGatewayInterface::class,
            PaddlePayment::class
        );

        $this->container->set(
            MailerInterface::class,
            fn() => new CustomMailer($this->config->mailer['dsn'])
        );

        static::$entityManager = new EntityManager(
            DriverManager::getConnection($this->config->db),
            ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Entity']
            )
        );

        return $this;
    }

}