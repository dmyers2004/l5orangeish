<?php

namespace Orange\Wip\Providers;

use Illuminate\Support\ServiceProvider;

class OrangeServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
			/**
			 * when they ask for Orange\Wip\Interfaces\MyEventInterface as in
			 *
			 * use Orange\Wip\Interfaces\MyEventInterface;
			 * public function index(MyEventInterface $event)
			 *
			 * return Orange\Wip\Libraries\MyEvent
			 */
			app()->singleton('Orange\Wip\Interfaces\MyEventInterface','Orange\Wip\Libraries\MyEvent');

			app()->bind('Orange\Wip\Interfaces\MyFooInterface','Orange\Wip\Libraries\MyEvent');

			/* Push config file out to /config folder when vendor:publish is called
			$this->publishes([
				__DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
			]);
			*/

			/* Regsiter your package's Routes with Laravel
			$this->loadRoutesFrom(__DIR__.'/routes.php');
			*/
			$this->loadRoutesFrom(__DIR__.'/../routes.php');

			/* Register your package's Migrations with Laravel
			$this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
			*/

			/* Register your package's Translations with Laravel
			$this->loadTranslationsFrom(__DIR__.'/path/to/translations', 'courier');
			*/

			/* Register your package's views with Laravel
			$this->loadViewsFrom(__DIR__.'/path/to/views', 'courier');

	    return view('courier::admin');
			*/
			$this->loadViewsFrom(__DIR__.'/../Views', 'orange-wip');

			/* To register your package's Artisan commands with Laravel
			if ($this->app->runningInConsole()) {
				$this->commands([
					FooCommand::class,
					BarCommand::class,
				]);
			}
			*/

			/* Push assets such as JavaScript, CSS, and images out to /public folder when vendor:publish is called
			$this->publishes([
        __DIR__.'/path/to/assets' => public_path('vendor/courier'),
    	], 'public');
    	*/

		}

} /* end class */
