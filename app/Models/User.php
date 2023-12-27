<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $email
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

	/**
	 * Allowing users to access a Filament panel.
	 *
	 * By default, all {@see User} models can access Filament locally. However, when deploying to production, you must
	 * update your `App\Models\User.php` to implement the FilamentUser contract — ensuring that only the correct users
	 * can access your panel.
	 *
	 * @link https://filamentphp.com/docs/3.x/panels/installation#deploying-to-production Filament documentation
	 */
	public function canAccessPanel(Panel $panel): bool
	{
		return str_ends_with($this->email, '@daniloquispe.dev') && $this->hasVerifiedEmail();
	}
}
