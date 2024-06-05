<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeruDistrict extends Model
{
    use HasFactory;

	protected $connection = 'ubigeo';

	protected $table = 'ubigeo_districts';

	protected $keyType = 'string';

	public function province(): BelongsTo
	{
		return $this->belongsTo(PeruProvince::class);
	}

	public function department(): BelongsTo
	{
		return $this->belongsTo(PeruDepartment::class);
	}
}
