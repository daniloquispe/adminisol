<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationLocation extends Model
{
    use HasFactory;

	protected $table = 'organization_location';

	protected $fillable = [
		'is_active',
		'city',
		'address',
		'is_billing',
		'html_map',
		'department_id',
		'district_id',
		'country_id',
		'province_id',
		'type_id',
		'name',
		'notes',
		'address_reference',
	];

	public function type(): BelongsTo
	{
		return $this->BelongsTo(OrganizationLocationType::class, 'type_id');
	}

	public function organization(): BelongsTo
	{
		return $this->belongsTo(Organization::class);
	}

	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class);
	}
}
