<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Casting the price to an integer.
 *
 * Filament stores currency values as integers (not floats) to avoid rounding and precision issues —a widely-accepted
 * approach in the Laravel community. However, this requires creating a cast in Laravel that transforms the float into
 * an integer when retrieved and back to an integer when stored in the database.
 *
 * @link https://filamentphp.com/docs/3.x/panels/getting-started#casting-the-price-to-an-integer
 */
class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): float
    {
		// Transform the integer stored in the database into a float.
		return round(floatval($value) / 100, precision: 2);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): float
    {
		// Transform the float into an integer for storage.
		return round(floatval($value) * 100);
    }
}
