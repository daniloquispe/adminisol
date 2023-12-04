<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Person
{
    use HasFactory;

	protected $table = 'contact';

	protected $fillable = [
		'last_name',
		'nickname',
		'first_name',
		'organization_id',
		'title',
		'birthdate',
		'notes',
		'status',
		'is_owner',
		'is_billing',
	];

	protected $casts = [
		'is_owner' => 'boolean',
		'is_billing' => 'boolean',
	];

	public function organization(): BelongsTo
	{
		return $this->belongsTo(Organization::class);
	}
}
