<?php

declare(strict_types=1);

use App\Core\MyEntityManager;
use App\Entity\Invoice;
use App\Entity\InvoiceItem;
use App\Enums\InvoiceStatus;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$items = [['Item 1', 1, 15], ['Item 2', 2, 7.5], ['Item 3', 4, 4.5]];

//$invoice = (new Invoice())
//    ->setAmount(50)
//    ->setNumber('1')
//    ->setStatus(InvoiceStatus::Pending)
//    ->setCreatedAt(new DateTime());
//
//foreach ($items as [$description, $quantity, $unitPrice]) {
//    $item = (new InvoiceItem())
//        ->setDescription($description)
//        ->setQuantity($quantity)
//        ->setUnitPrice($unitPrice);
//
//    $invoice->addItems($item);
//}
//
//$entityManager->persist($invoice);

/** @var Invoice $invoice */
$invoice = (new EntityManager())->entityManager->find(Invoice::class, 14);

$invoice->setStatus(InvoiceStatus::Paid);

/** @var InvoiceItem $item */
$item = $invoice->getItems()->get(0);
$item->setDescription('Foo bar');

$entityManager->flush();