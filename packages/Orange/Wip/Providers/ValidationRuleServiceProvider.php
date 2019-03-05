<?php

namespace Orange\Wip\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationRuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
			# https://laravel.com/docs/5.8/validation#custom-validation-rules

			/* need to cache into single file */
			foreach (glob(__DIR__.'/../Rules/*') as $file) {
				require $file;
			}
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
