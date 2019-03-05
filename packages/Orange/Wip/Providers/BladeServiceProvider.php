<?php

namespace Orange\Wip\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return string
	 */
	public function boot()
	{
		# https://codelike.pro/how-to-create-custom-blade-directives-in-laravel-5

		/* need to cache into single file */
		foreach (glob(__DIR__.'/../BladeDirectives/*') as $file) {
			require $file;
		}

		/*
		 Blade::directive('var', function ($expression) {
			$parts = str_getcsv($expression,',','\'');

  		return "<?php $".ltrim($parts[0],'$')." = '".$parts[1]."'; ?>";
  	});
  	*/
  
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}

} /* end class */
