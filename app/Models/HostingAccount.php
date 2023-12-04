<?php

namespace App\Models;

use App\Enums\HostingAccountStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $cpanel_custom_url
 * @property string $webmail_custom_url
 * @property-read string $cpanelUrl
 * @property-read Domain $mainDomain
 * @property-read string $webmailUrl
 */
class HostingAccount extends Model
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

	public function client(): BelongsTo
	{
		return $this->belongsTo(Organization::class, 'client_id');
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
}
