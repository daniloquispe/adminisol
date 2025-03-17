<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Abstract model for a renewable service.
 *
 * @package AdminISOL
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property Carbon $expiring_at Next renewable expiration date
 * @property-read Organization $customer
 * @method static Builder expiringIn30Days()
 */
abstract class Renewable extends Model
{
    use HasFactory;

	public function renewals(): MorphToMany
	{
		return $this->morphToMany(Renewal::class, 'renewable');
	}

	public function customer(): BelongsTo
	{
		return $this->belongsTo(Organization::class, 'client_id');
	}

	public abstract function scopeExpiringIn30Days(Builder $query): void;
}
