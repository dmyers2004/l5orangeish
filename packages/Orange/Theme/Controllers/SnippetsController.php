<?php

namespace Orange\Theme\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Orange\Wip\Models\Snippet;

class SnippetsController extends BaseController
{

	/*
	public function __construct()
  {
  	$this->middleware('auth');
  }
	*/

	public function index()
	{
		$records = Snippet::all();

		return view('orange-theme::snippets/index',compact('records'));
	}

	public function create()
	{
	}

	public function show()
	{
	}

	public function store()
	{
	}

	public function edit()
	{
	}

	public function update()
	{
	}

	public function destroy()
	{
	}

} /* end class */
