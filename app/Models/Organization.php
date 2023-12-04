<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $legal_name Legal (business) name
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
}
