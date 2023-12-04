<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name Plan type name
 */
class HostingPlanType extends Model
{
    use HasFactory;

	protected $table = 'hosting_plan_type';

//	protected $fillable = ['name', 'description', 'color', 'is_active', 'order'];

	protected $casts = ['is_active' => 'boolean'];

	protected $attributes = ['is_active' => true];

	public function plans(): HasMany
	{
		return $this->hasMany(HostingPlan::class, 'type_id');
	}
}
