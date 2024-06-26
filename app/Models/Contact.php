<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model for an organization's contact.
 *
 * This model allows a contact to work in various organizations, by using the {@see $organizations} property.
 *
 * @package AdminISOL\Contact
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property string $avatar_filename
 * @property-read  string $default_avatar_filename Default avatar filename (using {@link https://ui-avatars.com ui-avatars.com} service)
 * @property-read Collection $organizations Contact jobs (as organizations collection)
 */
class Contact extends Person
{
    use HasFactory;

	protected $table = 'contact';

/*	protected $fillable = [
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
	];*/

	protected $casts = [
		'birthdate' => 'date',
		'is_billing' => 'boolean',
		'is_owner' => 'boolean',
		'status' => ContactStatus::class,
	];

	public function defaultAvatarFilename(): Attribute
	{
		return Attribute::make(fn() => "https://ui-avatars.com/api/?background=random&name={$this->first_name} {$this->last_name}");
	}

	public function organizations(): BelongsToMany
	{
		return $this->belongsToMany(Organization::class, 'contact_organization', 'contact_id', 'organization_id')
			->withPivot(['title', 'email', 'is_owner', 'is_billing']);
	}
}
