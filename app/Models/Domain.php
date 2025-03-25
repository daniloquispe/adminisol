<?php

namespace App\Models;

use App\Enums\DomainStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model for an Internet domain.
 *
 * @package AdminISOL\Domain
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $name
 */
class Domain extends Renewable
{
    use HasFactory;

	protected $table = 'domain';

/*	protected $fillable = [
		'client_id',
		'name',
		'registered_at',
		'expiring_at',
		'cancelled_at',
		'is_external',
		'status',
		'notes',
	];*/

	protected function casts(): array
	{
		return [
			'registered_at' => 'date',
			'expiring_at' => 'date',
			'cancelled_at' => 'date',
			'is_external' => 'boolean',
			'status' => DomainStatus::class,
		];
	}

	public function name(): Attribute
	{
		return Attribute::make(set: fn(string $name) => $this->attributes['name'] = strtolower($name));
	}

	/*public function renewals(): MorphMany
	{
		return $this->morphMany(Renewal::class, 'service');
	}*/

	public function scopeExpiringIn30Days(Builder $query): void
	{
		$query->where('expiring_at', '<=', Carbon::today()->addDays(30))
			->whereNull('cancelled_at')
			->where('status', DomainStatus::Active);
	}
}
