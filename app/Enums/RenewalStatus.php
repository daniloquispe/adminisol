<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RenewalStatus: int implements HasLabel
{
	case NotStarted = 0;

	case EmailSent = 1;

	case PaymentVerified = 2;

	case Renewed = 9;

	case RejectedByClient = -1;

	public function getLabel(): ?string
	{
		return $this->name;
	}
}
