<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for a currency.
 *
 * @package AdminISOL\Currency
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $id Currency ID
 * @method Builder bySearch(string $search) Text search
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

	/**
	 * Scope: Text search.
	 *
	 * @param Builder $builder Query builder
	 * @param string $search Search string
	 * @return Builder
	 */
	public function scopeBySearch(Builder $builder, string $search): Builder
	{
		if ($search)
			$builder->where('id', 'like', "%$search%")
				->orWhere('name', 'like', "%$search%");

		return $builder;
	}
}
