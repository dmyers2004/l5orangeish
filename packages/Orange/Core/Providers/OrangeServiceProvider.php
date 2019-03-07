<?php

namespace Orange\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Orange\Core\Setting\Setting;

class OrangeServiceProvider extends ServiceProvider
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
		/* add the database settings */
		$settings = Cache::remember('cached_database_settings', 600, function() {
			return Setting::all(['file','key','value']);
		});

		foreach ($settings as $record) {
			config([$record->file.'.'.$record->key => $record->value]);
		}
		
		/*
		app()->singleton('Orange\Core\Libraries\Input','Orange\Core\Libraries\Input');
		app()->singleton('Orange\Core\Libraries\Input','Orange\Core\Libraries\Input');
		app()->singleton('Orange\Core\Libraries\Input','Orange\Core\Libraries\Input');
		app()->singleton('Orange\Core\Libraries\Input','Orange\Core\Libraries\Input');
		app()->singleton('Orange\Core\Libraries\Input','Orange\Core\Libraries\Input');
		*/

	}
}
