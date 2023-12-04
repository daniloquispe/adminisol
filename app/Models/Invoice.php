<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

	protected $table = 'invoice';

	protected $casts = [
		'date',
		'due_date',
		'canceled_at',
	];

	protected $fillable = [
		'address',
		'is_export',
		'number',
		'type_id',
		'receiver_id',
		'identification_document_type_id',
		'identification_number',
		'name',
		'date',
		'due_date',
		'currency_id',
		'status',
		'notes',
		'tax_date',
	];

	public function type(): BelongsTo
	{
		return $this->belongsTo(InvoiceType::class, 'type_id');
	}

	public function receiver(): BelongsTo
	{
		return $this->belongsTo(Organization::class, 'receiver');
	}

	public function identificationDocumentType(): BelongsTo
	{
		return $this->belongsTo(IdentificationDocumentType::class, 'type_id');
	}

	public function items(): HasMany
	{
		return $this->hasMany(InvoiceItem::class, 'invoice_id');
	}
}
