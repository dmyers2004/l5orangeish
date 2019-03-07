<?php

namespace Orange\Theme\Controllers;

use Illuminate\Routing\Controller as BaseController;

class MainController extends BaseController
{

	/*
	public function __construct()
  {
  	$this->middleware('auth');
  }
	*/

	public function index()
	{
		return view('orange-theme::main/index');
	}

} /* end class */
