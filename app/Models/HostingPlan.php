<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model for a hosting plan.
 *
 * @package AdminISOL\HostingPlan
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @see HostingPlanType, HostingAccount
 * @property string $name
 */
class HostingPlan extends Model
{
    use HasFactory;

	protected $table = 'hosting_plan';

/*	protected $fillable = [
		'name',
		'type_id',
		'is_active',
		'capacity',
		'capacity_unit',
		'transfer',
		'transfer_unit',
		'price_month',
		'price_year'
	];*/

	protected $casts = [
		'price_year' => MoneyCast::class,
		'price_month' => MoneyCast::class,
	];

	public function type(): BelongsTo
	{
		return $this->belongsTo(HostingPlanType::class, 'type_id');
	}

	public function accounts(): HasMany
	{
		return $this->hasMany(HostingAccount::class, 'plan_id');
	}
}
