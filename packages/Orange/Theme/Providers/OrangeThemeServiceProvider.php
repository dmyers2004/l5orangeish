<?php

namespace Orange\Theme\Providers;

use Illuminate\Support\ServiceProvider;

class OrangeThemeServiceProvider extends ServiceProvider
{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
				//
		}

		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot()
		{
			#error_reporting(E_ALL & ~E_NOTICE);

			/* Regsiter your package's Routes with Laravel
			$this->loadRoutesFrom(__DIR__.'/routes.php');
			*/
			$this->loadRoutesFrom(__DIR__.'/../routes.php');

			/* Register your package's views with Laravel
			$this->loadViewsFrom(__DIR__.'/path/to/views', 'courier');
			return view('courier::admin');
			*/

			$this->loadViewsFrom(__DIR__.'/../Views', 'orange-theme');

			# https://codelike.pro/how-to-create-custom-blade-directives-in-laravel-5
			/* need to cache into single file */
			foreach (glob(__DIR__.'/../BladeDirectives/*') as $file) {
				require $file;
			}

			# https://laravel.com/docs/5.8/validation#custom-validation-rules
			/* need to cache into single file */
			foreach (glob(__DIR__.'/../ValidationRules/*') as $file) {
				require $file;
			}

		}
}
