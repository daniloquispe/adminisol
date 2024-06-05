<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeruDepartment extends Model
{
    use HasFactory;

	protected $connection = 'ubigeo';

	protected $table = 'ubigeo_departments';

	protected $keyType = 'string';

	public function provinces(): HasMany
	{
		return $this->hasMany(PeruProvince::class, 'department_id');
	}
}
