<?php

namespace Database\Seeders;

use App\Models\IdentificationDocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$types = [
			['code' => '0', 'name' => 'Otro'],
			['code' => '1', 'name' => 'DNI'],
			['code' => '4', 'name' => 'CE'],
			['code' => '6', 'name' => 'RUC'],
			['code' => '7', 'name' => 'Pasaporte'],
			['code' => 'A', 'name' => 'Cédula Diplomática de Identidad'],
		];

		foreach ($types as $type)
			IdentificationDocumentType::create($type);
    }
}
