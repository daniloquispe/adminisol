<?php

namespace Database\Seeders;

use App\Models\HostingPlanType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostingPlanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		HostingPlanType::create(['order' => 1, 'name' => 'Básico', 'description' => 'Ideal para sitios web personales, landing pages y negocios que dan su primer paso en Internet.', 'color' => '#3b3d40']);
		HostingPlanType::create(['order' => 2, 'name' => 'Profesional', 'description' => 'Ideal para sitios web profesionales, portafolios, catálogos de imágenes o fotos, tiendas virtuales, intranets o negocios en crecimiento.', 'color' => '#3b3d40']);
		HostingPlanType::create(['order' => 3, 'name' => 'Empresarial', 'description' => 'Ideal para sitios web empresariales, correo electrónico corporativo, extranets, sistemas CRM o empresas de mayor tamaño y/o volumen de información.', 'color' => '#3b3d40']);
    }
}
