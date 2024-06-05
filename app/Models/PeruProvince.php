<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeruProvince extends Model
{
    use HasFactory;

	protected $connection = 'ubigeo';

	protected $table = 'ubigeo_provinces';

	protected $keyType = 'string';

	public function department(): BelongsTo
	{
		return $this->belongsTo(PeruDepartment::class);
	}

	public function districts(): HasMany
	{
		return $this->hasMany(PeruDistrict::class, 'province_id');
	}
}
