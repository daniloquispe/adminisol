<?php

namespace Database\Seeders;

use App\Models\Organization;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Database seeder for organizations.
 *
 * @package AdminIsol\Organization
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @see OrganizationFactory
 */
class OrganizationSeeder extends Seeder
{
	use WithFaker;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		if (app()->isLocal())
			Organization::factory(rand(100, 200))->create();
    }
}
