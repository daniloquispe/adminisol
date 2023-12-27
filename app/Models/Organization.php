<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $legal_name Legal (business) name
 * @method void clients() Scope for clients
 * @method void prospects() Scope for prospecting organizations (not clients nor vendors yet)
 * @method void vendors() Scope for vendors
 */
class Organization extends Model
{
    use HasFactory;

	protected $table = 'organization';

	public function invoiceType(): BelongsTo
	{
		return $this->belongsTo(InvoiceType::class);
	}

	public function locations(): HasMany
	{
		return $this->hasMany(OrganizationLocation::class);
	}

	public function contacts(): HasMany
	{
		return $this->hasMany(Contact::class);
	}

	public function scopeClients(Builder $query): void
	{
		$query->whereNotNull('as_client_at');
	}

	public function scopeVendors(Builder $query): void
	{
		$query->whereNotNull('as_vendor_at');
	}

	public function scopeProspects(Builder $query): void
	{
		$query->whereNotNull('prospecting_at');
	}
}
