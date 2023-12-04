<?php

namespace App\Enums;

enum HostingAccountStatus: int
{
	case Active = 1;
	case Suspended = 0;
	case Terminated = -1;
}
