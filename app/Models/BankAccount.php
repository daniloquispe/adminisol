<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_account';

/*	protected $fillable = [
		'is_active',
		'cci',
		'iban',
		'bank_id',
		'currency_id',
		'number',
	];*/

	protected $attributes = ['is_active' => true];

	protected $casts = ['is_active' => 'boolean'];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

	public function currency(): BelongsTo
	{
		return $this->belongsTo(Currency::class);
	}
}
