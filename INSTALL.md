# AdminISOL

## System requirements

### Server software requirements

You will need the following installed packages:

* [Git](https://git-scm.com/)
* [Composer](https://getcomposer.org/)

Verify also if the following PHP extensions are installed and enabled in your PHP installation:

* CType (`ext-ctype`)
* cURL (`ext-curl`)
* DOM (`ext-dom`)
* FileInfo (`ext-fileinfo`)
* GD (`ext-gd`)
* iconv  (`ext-iconv`)
* MBString (`ext-mbstring`)
* MySQL (`ext-mysql`)
* OpenSSL (`ext-openssl`)
* PDO (`ext-pdo`)
* SimpleXML (`ext-simplexml`)
* Tokenizer (`ext-tokenizer`)
* XMLReader (`ext-xmlreader`)
* XMLWriter (`ext-xmlwriter`)
* ZIP (`ext-zip`)

### 3rd-party services requirements

You will also need integrations with the following services/platforms:

* [BugSnag](https://www.bugsnag.com) API

## Source code

Get full source code from
[AppData Git repository](https://development.bls01-development.net/daniloquispe/appdata).

This is a private repository, so you will need a user account in Bilingual Git instance. Contact IT department to assign
your Git user account.

Download to document root directory in web server (i.e. `/var/www/` or `/var/www/html/` for Apache in Ubuntu or Debian).
Check your HTTP server documentation to locate correct directory.

After downloading, enter to the directory with full source code and run one of these command:

**Development or staging environment:**

```shell
composer install
```

**Production environment:**

```shell
composer install --optimize-autoloader --no-dev
``` 

This will download and install [Laravel](https://laravel.com) engine and all necessary PHP libraries (dependencies).

## Initialize environment

You will need an `.env` file in project's root directory. If installation process doesn't create this `.env` file
automatically, you can use the `.env.example` file as a template to create your own `.env` file:

```shell
cp .env.example .env
```

Once you have a `.env` file, you will need a key stored in this file. Verify in `.env` file if `APP_KEY` key exists and
has a value (the encrypted key for your application). If not, you can generate a new app key by running this command:

```shell
php artisan key:generate
```

Now, modify the following keys in your `.env` file:

```dotenv
APP_NAME=AdminISOL
APP_URL=https://your.application.url

# Integration with BugSnag
BUGSNAG_API_KEY=<your-api-key>
```

Plus, depending on your installation environment, set these additional keys:

**Development or staging environment:**

```dotenv
APP_ENV=local
APP_DEBUG=true
```

**Production environment:**

```dotenv
APP_ENV=production
APP_DEBUG=false
```

## Configuration cache

In **production environment**, you will need to generate cache files for configuration, routes and views:

```shell
# Configuration cache
php artisan config:cache

# Routes cache
php artisan route:cache

# Blade views cache
php artisan view:cache
```

If you update a route, view or configuration options, you must re-run the correct command from above list.

In **non-production environments**, this step is optional.

## Database

Create a new database in [MariaDB](https://mariadb.com/).

You should also create a user in MariaDB to access the recently-created database (using `root` user is **not**
recommended).

Now, locate and update the following lines in `.env` file:

```dotenv
DB_HOST=<your-server-IP-or-URL>
DB_PORT=<your-server-port>
DB_DATABASE=<your-database-name>
DB_USERNAME=<your-database-username>
DB_PASSWORD=<your-database-password>
```

Then, execute this command to generate all necessary tables in database:

```shell
# Generate job queue tables
php artisan queue:table

# Generate and populate AdminISOL tables
php artisan migrate  --seed
```

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

## Useful links

* [Deploying Laravel applications](https://laravel.com/docs/10.x/deployment)
* [Environment configuration](https://laravel.com/docs/10.x/configuration)
