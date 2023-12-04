<?php

namespace App\Models;

use App\Enums\DomainStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for an Internet domain.
 *
 * @property Carbon $expiring_at Domain's next expiration date
 * @property string $name
 */
class Domain extends Model
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

	public function client(): BelongsTo
	{
		return $this->belongsTo(Organization::class, 'client_id');
	}
}
