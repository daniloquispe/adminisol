<?php

namespace App\Enums;

enum DomainStatus: int
{
	case Unregistered = 0;
	case Active = 1;
	case Expired = 2;
	case Cancelled = -1;
}
