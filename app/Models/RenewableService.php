<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Abstract model for a renewable service.
 *
 * @package AdminISOL
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property Carbon $expiring_at Service's next expiration date
 * @property-read Organization $client
 * @method static Builder expiringIn30Days()
 */
abstract class RenewableService extends Model
{
    use HasFactory;

	public function client(): BelongsTo
	{
		return $this->belongsTo(Organization::class, 'client_id');
	}

	public function scopeExpiringIn30Days(Builder $query): void
	{
		$query->where('expiring_at', '<=', Carbon::today()->addDays(30));
	}
}
