<?php

namespace App\Models;

use App\Enums\DomainStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model for an Internet domain.
 *
 * @package AdminISOL\Domain
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $name
 */
class Domain extends RenewableService
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

	protected $casts = [
		'registered_at' => 'date',
		'expiring_at' => 'date',
		'cancelled_at' => 'date',
		'is_external' => 'boolean',
		'status' => DomainStatus::class,
	];

	public function name(): Attribute
	{
		return Attribute::make(null, fn(string $name) => $this->attributes['name'] = strtolower($name));
	}
}
