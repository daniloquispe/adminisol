# AdminISOL

## Deploying to production

Reference:
[Filament documentation](https://filamentphp.com/docs/3.x/panels/installation#allowing-users-to-access-a-panel).

### Allowing models to access the panel

By default, all `User` models can access Filament locally. However, when deploying to production, you must update your
`App\Models\User.php` to implement the `FilamentUser` contract — ensuring that only the correct users can access your
panel:

```php
namespace App\Models;
 
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
 
class User extends Authenticatable implements FilamentUser
{
    // ...
 
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }
}
```

If you don't complete these steps, a 403 Forbidden error will be returned when accessing the app in production.

### Caching icons

```shell
php artisan icons:cache
```
