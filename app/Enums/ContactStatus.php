<?php

namespace App\Enums;

enum ContactStatus: int
{
	case Prospect = 0;
	case Active = 1;
	case Inactive = -1;
}
