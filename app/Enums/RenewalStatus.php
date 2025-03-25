<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RenewalStatus: int implements HasLabel
{
	case NotStarted = 0;

	case InProgress = 1;

	case Renewed = 2;

	case RejectedByClient = -1;

	public function getLabel(): ?string
	{
		return $this->name;
	}
}
