<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Abstract model for a generic person.
 *
 * @property Carbon|null $birthdate
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property-read int $age
 * @property-read string $last_and_first_name
 * @property-read Carbon $next_birthday
 */
abstract class Person extends Model
{
    use HasFactory;

	protected $fillable = ['first_name', 'last_name', 'birthdate'];

	protected $casts = ['birthdate' => 'date'];

	public function lastAndFirstName(): Attribute
	{
		return new Attribute(fn() => $this->last_name . ', ' . $this->first_name);
	}

	public function nextBirthday(): Attribute
	{
		return new Attribute(function ()
		{
			$today = Carbon::today();

			$date = $this->birthdate->clone();
			$date->year($today->year);

			return $today->diffInDays($date, false) < 0
				? $date->addYear()
				: $date;
		});
	}

	public function age(): Attribute
	{
		return new Attribute(fn() => $this->birthdate?->age);
	}

	public function scopeBirthdaysToday(Builder $query): Builder
	{
		$today = Carbon::today();

		return $query->whereYear('birthdate', $today->year)->whereMonth('birthdate', $today->month);
	}
}
