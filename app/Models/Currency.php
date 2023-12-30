<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for a currency.
 *
 * @package AdminISOL\Currency
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $id Currency ID
 */
class Currency extends Model
{
    use HasFactory;

	protected $table = 'currency';

//	protected $keyType = 'string';

//	protected $fillable = ['id', 'name'];

	/**
	 * Attribute: Currency code.
	 *
	 * @see $id
	 */
	public function code(): Attribute
	{
		return Attribute::make(set: fn(string $value) => strtoupper($value));
	}
}
