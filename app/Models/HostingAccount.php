<?php

namespace App\Models;

use App\Enums\HostingAccountStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model for a hosting account.
 *
 * @package AdminISOL\HostingAccount
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @see HostingPlan, HostingPlanType
 * @property string $cpanel_custom_url
 * @property HostingAccountStatus $status
 * @property string $webmail_custom_url
 * @property-read string $cpanelUrl Custom cPanel URL
 * @property-read Domain $mainDomain
 * @property-read HostingPlan $plan
 * @property-read string $webmailUrl Custom Webmail URL
 */
class HostingAccount extends Renewable
{
    use HasFactory;

	protected $table = 'hosting_account';

/*	protected $fillable = [
		'cpanel_custom_url',
		'webmail_custom_url',
		'client_id',
		'plan_id',
		'main_domain_id',
		'registered_at',
		'expiring_at',
		'terminated_at',
		'status',
		'notes'
	];*/

	protected $casts = [
		'registered_at' => 'date',
		'expiring_at' => 'date',
		'terminated_at' => 'date',
		'status' => HostingAccountStatus::class,
	];

	public function name(): Attribute
	{
		$this->loadMissing('mainDomain:id,name');

		return Attribute::make(fn() => $this->mainDomain->name);
	}

	public function plan(): BelongsTo
	{
		return $this->belongsTo(HostingPlan::class, 'plan_id');
	}

	public function mainDomain(): HasOne
	{
		return $this->hasOne(Domain::class, 'id', 'main_domain_id');
	}

	public function cpanelUrl(): Attribute
	{
		return Attribute::make(fn() => $this->cpanel_custom_url ?? 'https://www.' . $this->mainDomain->name . ':2083');
	}

	public function webmailUrl(): Attribute
	{
		return Attribute::make(fn() => $this->webmail_custom_url ?? 'https://www.' . $this->mainDomain->name . ':2096');
	}

	public function scopeExpiringIn30Days(Builder $query): void
	{
		$query->where('expiring_at', '<=', Carbon::today()->addDays(30))
			->whereNull('terminated_at')
			->where('status', HostingAccountStatus::Active);
	}
}
