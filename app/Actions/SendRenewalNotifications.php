<?php

namespace App\Actions;

use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Domain;
use App\Models\HostingAccount;
use App\Models\Renewable;
use App\Models\Renewal;
use App\Notifications\ServicesRenewal;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class SendRenewalNotifications
{
	public function execute(SendRenewalNotification $action): void
	{
		// Pending renewals
		$renewals = Renewal::query()
			->whereNull('notification_sent_at')
			->get();

		foreach ($renewals as $renewal)
			$action->execute($renewal, $this->getBankAccounts());
	}

	/*public function __old_execute(int $daysBefore = 30): void
	{
		// Reference date
		$date = Carbon::today()->addDays($daysBefore);

		// Renewable hosting accounts
		$hostingAccounts = HostingAccount::expiringIn30Days()
			->get();

		// Renewable domains
		$domains = Domain::expiringIn30Days()
			->where('is_external', false)
			->get();

		$renewableGroups = [$hostingAccounts, $domains];

		$organizationsToNotify = [];
		$servicesPerOrganization = [];

		foreach ($renewableGroups as $renewables)
			foreach ($renewables as $renewable)
			{
				$organization = $renewable->client;

				$billingContacts = $organization->activeContacts()
					->wherePivot('is_billing', true)
					->get();

				if (!$billingContacts->count())
					continue;

				$notifiableContacts = [];

				foreach ($billingContacts as $billingContact)
					$notifiableContacts[] = [
						'full_name' => $billingContact->last_and_first_name,
						'name' => $billingContact->full_name,
						'email' => $billingContact->pivot->email,
					];

				$organizationsToNotify[] = [
					'legal_name' => $organization->legal_name,
					'expiring_at' => $renewable->expiring_at,
					'billingContacts' => $notifiableContacts,
				];
			}

		Notification::send($organizationsToNotify, new ServicesRenewal());

		foreach ($organizationsToNotify as $organization)
			Notification::send($organization, new ServicesRenewal());
	}*/

	private function getBankAccounts(): Collection
	{
		return BankAccount::query()
			->where('is_active', true)
			->with('bank')
			->get();
	}
}
