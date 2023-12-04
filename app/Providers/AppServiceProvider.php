<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
	 *
	 * Filament only saves valid data to models so the models can be unguarded safely.
	 *
	 * @link https://filamentphp.com/docs/3.x/panels/getting-started#unguarding-all-models Filament documentaton
     */
    public function boot(): void
    {
		// Unguarding all models
		Model::unguard();
    }
}
