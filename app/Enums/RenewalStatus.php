<?php

namespace App\Enums;

enum RenewalStatus: int
{
	case NotStarted = 0;

	case InProgress = 1;

	case Renewed = 2;

	case RejectedByClient = -1;
}
