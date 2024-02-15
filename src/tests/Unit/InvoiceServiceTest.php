<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayService;
use App\Services\SalesTaxService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{

    private InvoiceService $invoiceService;
    private EmailService $emailServiceMock;

    public function test_it_processes_invoice(): void
    {
        $customer = ['name' => 'Karam'];
        $amount   = 150;
        $result   = $this->invoiceService->process($customer, $amount);

        $this->assertTrue($result);
    }

    public function test_it_sends_receipt_email_when_invoice_is_processed(
    ): void
    {
        $this->emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with(
                ['name' => 'Karam'],
                'receipt'
            );

        $customer = ['name' => 'Karam'];
        $amount   = 150;
        $result   = $this->invoiceService->process($customer, $amount);

        // Then assert the invoice was processed successfully
        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $paymentGatewayServiceMock = $this->createMock(
            PaymentGatewayService::class
        );

        $this->emailServiceMock = $this->createMock(EmailService::class);

        $paymentGatewayServiceMock->method('charge')->willReturn(true);

        $this->invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $paymentGatewayServiceMock,
            $this->emailServiceMock
        );
    }

}