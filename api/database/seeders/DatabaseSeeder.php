<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::create([
            'name' => 'Mustermann GmbH',
            'slug' => 'mustermann-gmbh',
            'email_address' => 'mustermann-gmbh@in.rechnungspost.de',
            'plan' => 'starter',
        ]);

        $company2 = Company::create([
            'name' => 'Demo AG',
            'slug' => 'demo-ag',
            'email_address' => 'demo-ag@in.rechnungspost.de',
            'plan' => 'business',
        ]);

        User::create([
            'company_id' => $company1->id,
            'role' => 'owner',
            'name' => 'Max Mustermann',
            'email' => 'max@mustermann-gmbh.de',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'company_id' => $company2->id,
            'role' => 'owner',
            'name' => 'Anna Demo',
            'email' => 'anna@demo-ag.de',
            'password' => Hash::make('password'),
        ]);

        // 3 XRechnung invoices for company 1
        $xrechnungFormats = ['xrechnung-ubl', 'xrechnung-cii', 'xrechnung-ubl'];
        foreach ($xrechnungFormats as $i => $format) {
            $net = 1000 + $i * 500;
            $vatAmt = $net * 0.19;
            $gross = $net * 1.19;
            $invoiceNum = 'RE-2024-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT);
            $vatId = 'DE' . str_pad((string) (123456789 + $i), 9, '0');

            Invoice::create([
                'company_id' => $company1->id,
                'sender_name' => 'Lieferant ' . ($i + 1) . ' GmbH',
                'sender_vat_id' => $vatId,
                'invoice_number' => $invoiceNum,
                'date' => now()->subDays(30 - $i * 5),
                'due_date' => now()->addDays(14 + $i * 5),
                'amount_net' => $net,
                'amount_gross' => $gross,
                'vat_amount' => $vatAmt,
                'currency' => 'EUR',
                'format' => $format,
                'status' => 'valid',
                'raw_xml' => '<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"><ID>' . $invoiceNum . '</ID></Invoice>',
                'parsed_dto' => [
                    'invoice_number' => $invoiceNum,
                    'date' => now()->subDays(30 - $i * 5)->toDateString(),
                    'due_date' => now()->addDays(14 + $i * 5)->toDateString(),
                    'sender' => ['name' => 'Lieferant ' . ($i + 1) . ' GmbH', 'vat_id' => $vatId],
                    'amount_net' => $net,
                    'amount_gross' => $gross,
                    'vat_amount' => $vatAmt,
                    'currency' => 'EUR',
                    'format' => $format,
                ],
                'validation_report' => ['valid' => true, 'profile' => $format, 'errors' => []],
                'received_at' => now()->subDays(30 - $i * 5),
            ]);
        }

        // 2 ZUGFeRD invoices for company 2
        $zugferdFormats = ['zugferd-basic', 'zugferd-comfort'];
        foreach ($zugferdFormats as $i => $format) {
            $net = 2500 + $i * 1000;
            $vatAmt = $net * 0.19;
            $gross = $net * 1.19;
            $invoiceNum = 'ZF-2024-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT);
            $vatId = 'DE' . str_pad((string) (987654321 + $i), 9, '0');

            Invoice::create([
                'company_id' => $company2->id,
                'sender_name' => 'ZF Lieferant ' . ($i + 1) . ' AG',
                'sender_vat_id' => $vatId,
                'invoice_number' => $invoiceNum,
                'date' => now()->subDays(20 - $i * 7),
                'due_date' => now()->addDays(21 + $i * 7),
                'amount_net' => $net,
                'amount_gross' => $gross,
                'vat_amount' => $vatAmt,
                'currency' => 'EUR',
                'format' => $format,
                'status' => 'forwarded',
                'raw_xml' => '<?xml version="1.0" encoding="UTF-8"?><rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"><rsm:ExchangedDocumentContext/></rsm:CrossIndustryInvoice>',
                'parsed_dto' => [
                    'invoice_number' => $invoiceNum,
                    'format' => $format,
                    'sender' => ['name' => 'ZF Lieferant ' . ($i + 1) . ' AG'],
                    'amount_net' => $net,
                    'amount_gross' => $gross,
                    'currency' => 'EUR',
                ],
                'validation_report' => ['valid' => true, 'profile' => $format, 'errors' => []],
                'received_at' => now()->subDays(20 - $i * 7),
            ]);
        }
    }
}
