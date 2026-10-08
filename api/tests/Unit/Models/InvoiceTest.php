<?php

namespace Tests\Unit\Models;

use App\Models\Invoice;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function test_invoice_has_expected_fillable(): void
    {
        $invoice = new Invoice();
        $this->assertContains('invoice_number', $invoice->getFillable());
        $this->assertContains('format', $invoice->getFillable());
        $this->assertContains('status', $invoice->getFillable());
    }
}
