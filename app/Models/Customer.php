<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @package AdminISOL\Organization
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class Customer extends Organization
{
	public function hostingAccounts(): HasMany
	{
		return $this->hasMany(HostingAccount::class, 'client_id');
	}

	public function domains(): HasMany
	{
		return $this->hasMany(Domain::class, 'client_id');
	}
}
