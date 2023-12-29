<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for a contact.
 *
 * @package AdminISOL\Contact
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $job_title Contact's job title in organization
 */
class Contact extends Person
{
    use HasFactory;

	protected $table = 'contact';

	protected $fillable = [
		'last_name',
		'nickname',
		'first_name',
		'organization_id',
		'job_title',
		'birthdate',
		'notes',
		'status',
		'is_owner',
		'is_billing',
		'avatar_filename',
	];

	protected $casts = [
		'birthdate' => 'date',
		'is_billing' => 'boolean',
		'is_owner' => 'boolean',
		'status' => ContactStatus::class,
	];

	public function organization(): BelongsTo
	{
		return $this->belongsTo(Organization::class);
	}
}
