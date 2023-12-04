<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePayment extends Model
{
    use HasFactory;

	protected $table = 'invoice_payment';

	protected $fillable = [
		'invoice_id',
		'date',
		'payment_date',
		'amount',
		'currency_id',
	];

	protected $casts = [
		'date' => 'date',
		'payment_date' => 'date'
	];

	public function invoice(): BelongsTo
	{
		return $this->belongsTo(Invoice::class);
	}
}
