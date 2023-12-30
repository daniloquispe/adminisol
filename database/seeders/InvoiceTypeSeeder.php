<?php

namespace Database\Seeders;

use App\Models\InvoiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
	 *
	 * @todo Complete with all invoice types from SUNAT tables.
     */
    public function run(): void
    {
		InvoiceType::create(['code' => '00', 'name' => 'Otros', 'has_tax' => false, 'is_active' => true]);
		InvoiceType::create(['code' => '01', 'name' => 'Factura', 'has_tax' => true, 'is_active' => true]);
		InvoiceType::create(['code' => '02', 'name' => 'Recibo por honorarios', 'has_tax' => false, 'is_active' => true]);
		InvoiceType::create(['code' => '03', 'name' => 'Boleta de venta', 'has_tax' => false, 'is_active' => true]);
    }
}
