<?php

namespace Orange\Theme\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Orange\Wip\Models\Snippet;
use function GuzzleHttp\json_encode;

class SnippetsController extends BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$records = Snippet::all();

		return view('orange-theme::snippets/index',compact('records'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$record = New Snippet;
		$method = 'POST';

		return view('orange-theme::snippets/details',compact('record','method'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$snippet = Snippet::create($request->all());

		return $snippet->messageBag();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $primaryId
	 * @return \Illuminate\Http\Response
	 */
	public function show($primaryId)
	{
		$record = Snippet::findOrFail($primaryId);

		return view('orange-theme::snippets/details',compact('record'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $primaryId
	 * @return \Illuminate\Http\Response
	 */
	public function edit($primaryId)
	{
		$record = Snippet::findOrFail($primaryId);
		$method = 'PATCH';

		return view('orange-theme::snippets/details',compact('record','method'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $primaryId
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $primaryId)
	{
		$snippet = Snippet::findOrFail($primaryId);
		$snippet->update($request->all());

		return $snippet->messageBag();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $primaryId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($primaryId)
	{
		$snippet = Company::findOrFail($primaryId);

		$snippet->delete();

		return $snippet->messageBag();
	}
} /* end class */
