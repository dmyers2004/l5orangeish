<?php

namespace Orange\Theme\Controllers\Traits;

use Illuminate\Http\Request;

trait CrudTrait {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$records = $this->controller_model::all();

		return view('orange-theme::snippets/index',['records'=>$records,'controller_path'=>$this->controller_path]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$record = New $this->controller_model;
		$method = 'POST';
		$title = 'Create';

		return view('orange-theme::snippets/details',compact('record','method','title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$snippet = $this->controller_model::create($request->all());

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
		$record = $this->controller_model::findOrFail($primaryId);
		$method = 'X';
		$title = 'Show';

		return view('orange-theme::snippets/show',compact('record','method','title'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $primaryId
	 * @return \Illuminate\Http\Response
	 */
	public function edit($primaryId)
	{
		$record = $this->controller_model::findOrFail($primaryId);
		$method = 'PATCH';
		$title = 'Update';

		return view('orange-theme::snippets/details',compact('record','method','title'));
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
		$snippet = $this->controller_model::findOrFail($primaryId);

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
		$snippet = $this->controller_model::findOrFail($primaryId);

		$snippet->delete();

		return $snippet->messageBag();
	}

} /* end trait */
