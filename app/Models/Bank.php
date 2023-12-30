<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for a bank.
 *
 * @package AdminISOL\Bank
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $swift SWIFT code
 */
class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';

//    protected $fillable = ['name', 'swift', 'is_enabled'];

    protected $casts = ['is_enabled' => 'boolean'];

	/**
	 * Attribute: SWIFT code.
	 *
	 * When set, code is converted to uppercase.
	 *
	 * @see $swift
	 */
	public function swift(): Attribute
	{
		return Attribute::make(set: fn($value) => strtoupper($value));
	}

}
