<?php

namespace Orange\Core\BaseController;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as IlluminateController;

class BaseController extends IlluminateController
{

	public function __construct()
	{
		/**
		 * Add these value to the view
		 */
		View::share([
			'controller'        => $this->controller,
			'controller_path'   => $this->controller_path,
			'controller_title'  => $this->controller_title,
			'controller_titles' => $this->controller_titles,
		]);

	}

}
