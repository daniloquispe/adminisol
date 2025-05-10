<?php

namespace App\Actions;

use App\Mail\RenewalNotification;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Renewal;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendRenewalNotification
{
	public function execute(Renewal $renewal, Collection $bankAccounts): void
	{
		$customer = $renewal->customer()
			->with('activeContacts')
			->first();

		$billingContacts = $customer->activeContacts()
			->wherePivot('is_billing', true)
			->get();

		if (!$billingContacts->count())
			return;

//		Mail::to($billingContacts)->send(new RenewalNotification('domain.com'));
		foreach ($billingContacts as $billingContact)
			Mail::to($this->getContactEmail($billingContact, $customer))->send(new RenewalNotification($billingContact->first_name, $renewal, $bankAccounts));

		// Mask as "notification sent"
		$renewal->update(['notification_sent_at' => Carbon::today()]);
	}

	private function getContactEmail(Contact $contact, Organization $customer): string
	{
		return $contact->organizations()
			->where('organization_id', $customer->id)
			->first()
			->pivot
			->email;
	}
}
