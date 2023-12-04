<?php

namespace App\Enums;

enum DomainStatus: int
{
	case Active = 1;
	case Expired = 0;
}
