<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @deprecated Use {@see Organization} model instead of this one
 * @see Organization
 */
class Client extends Organization
{
    use HasFactory;

	protected $table = 'client';

	protected $fillable = [
		'arrived_at',
		'type_id',
		'name',
		'business_name',
		'identification_type_id',
		'identification_number',
		'invoice_type_id',
		'notes',
		'status',
	];

	protected $casts = ['arrived_at' => 'date'];

	public function identificationType(): BelongsTo
	{
		return $this->belongsTo(IdentificationType::class, 'identification_type_id');
	}

	public function invoiceType(): BelongsTo
	{
		return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
	}
}
