<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		$this->call([
			UserSeeder::class,
			// Maintenance tables
			CurrencySeeder::class,
			IdentificationTypeSeeder::class,
			InvoiceTypeSeeder::class,
			HostingPlanTypeSeeder::class,
			// Organizations
			OrganizationSeeder::class,
		]);
    }
}
