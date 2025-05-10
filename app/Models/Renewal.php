<?php

namespace App\Models;

use App\Enums\RenewalStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property Carbon $due_at
 * @property string $notes
 * @property Carbon|null $notification_sent_at Last e-mail notification send date
 * @property Carbon|null $payment_verified_at
 * @property Carbon|null $renewed_at
 * @property int $service_id Renewable service ID
 * @property-read float $amount Total amount
 * @property-read Customer $customer
 * @property-read RenewalStatus $status Renewal process status
 */
class Renewal extends Model
{
	protected $fillable = ['notification_sent_at'];

	protected function casts(): array
	{
		return [
			'due_at' => 'date',
			'notification_sent_at' => 'date',
			'payment_verified_at' => 'date',
			'renewed_at' => 'date',
			'invoice_sent_at' => 'date',
		];
	}

	public function hostingAccounts(): MorphToMany
	{
		return $this->morphedByMany(HostingAccount::class, 'renewable')
			->withPivot('amount');
	}

	public function domains(): MorphToMany
	{
		return $this->morphedByMany(Domain::class, 'renewable')
			->withPivot('amount');
	}

	public function customer(): BelongsTo
	{
		return $this->belongsTo(Customer::class);
	}

	public function status(): Attribute
	{
		return Attribute::make(function ()
		{
			if ($this->renewed_at)
				return RenewalStatus::Renewed;

			if ($this->payment_verified_at)
				return RenewalStatus::PaymentVerified;

			if ($this->notification_sent_at)
				return RenewalStatus::EmailSent;

			return RenewalStatus::NotStarted;
		});
	}

	public function amount(): Attribute
	{
		return Attribute::make(function ()
		{
			return $this->hostingAccounts()->sum('amount') + $this->domains()->sum('amount');
		});
	}

	public function isOverdue(): Attribute
	{
		return Attribute::make(fn(): bool => $this->due_at->isPast());
	}
}
