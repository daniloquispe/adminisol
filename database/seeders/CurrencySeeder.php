<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Database seeder for currencies.
 *
 * @package AdminISOL\Currency
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		Currency::create(['code' => 'PEN', 'name' => 'Peruvian Sol']);
		Currency::create(['code' => 'USD', 'name' => 'US Dollar']);
    }
}
