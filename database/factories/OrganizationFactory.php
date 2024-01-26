<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Database factory for organizations.
 *
 * @package AdminIsol\Organization
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$isClient = $this->faker->boolean(75);
		$isVendor = $this->faker->boolean(20);
		$isProspect = $this->faker->boolean(90);

		$prospectingDate = $this->faker->date();

        return [
			'is_enabled' => $this->faker->boolean(85),
			'name' => $this->faker->sentence(2),
			'legal_name' => $this->faker->sentence(3),
			'prospecting_at' => $isProspect ? $prospectingDate : null,
			'as_client_at' => $isClient ? Carbon::parse($prospectingDate)->addDays(rand(0, 45)) : null,
			'as_vendor_at' => $isVendor ? Carbon::parse($prospectingDate)->addDays(rand(0, 45)) : null,
        ];
    }
}
