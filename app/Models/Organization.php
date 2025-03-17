<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model for a generic organization.
 *
 * An organization can be one or more of these:
 *
 * - Customer
 * - Vendor
 * - Prospect (possible customer)
 *
 * @package AdminISOL\Organization
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @property int $id Organization ID
 * @property string $legal_name Legal (business) name
 * @property-read Collection $active_contacts Active contacts list (as collection)
 * @property-read Collection $contacts Contacts list (as collection)
 * @property-read IdentificationDocumentType|null identificationDocumentType
 * @method static Builder customers() Scope for customers
 * @method static Builder prospects() Scope for prospecting organizations (not customers nor vendors yet)
 * @method static Builder vendors() Scope for vendors
 */
class Organization extends Model
{
    use HasFactory;

	protected $table = 'organization';

	public function identificationDocumentType(): BelongsTo
	{
		return $this->belongsTo(IdentificationDocumentType::class, 'id_doc_type_id');
	}

	public function invoiceType(): BelongsTo
	{
		return $this->belongsTo(InvoiceType::class);
	}

	public function locations(): HasMany
	{
		return $this->hasMany(OrganizationLocation::class);
	}

	public function contacts(): BelongsToMany
	{
		return $this->belongsToMany(Contact::class, 'contact_organization', 'organization_id', 'contact_id')
			->withPivot(['title', 'email', 'is_owner', 'is_billing']);
	}

	public function activeContacts(): BelongsToMany
	{
		return $this->contacts()->where('status', ContactStatus::Active);
	}

	public function scopeClients(Builder $query): void
	{
		$query->whereNotNull('as_client_at');
	}

	public function scopeCustomers(Builder $query): void
	{
		$query->whereNotNull('as_client_at');
	}

	public function scopeVendors(Builder $query): void
	{
		$query->whereNotNull('as_vendor_at');
	}

	public function scopeProspects(Builder $query): void
	{
		$query->whereNotNull('prospecting_at');
	}

	/**
	 * Return this organization as a {@see Customer customer model}
	 *
	 * @see Customer
	 */
	public function asCustomer(): Customer
	{
		return new Customer($this->attributes);
	}
}
