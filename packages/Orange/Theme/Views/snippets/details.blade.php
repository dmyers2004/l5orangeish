@extends('orange-theme::_templates/default')

@section('content')

<div class="row">
	<div class="col-md">
		<h2>
			@if($method == 'POST')New
			@else Edit
			@endif
			Snippet
		</h2>
	</div>
	<div class="col-md">
		<div class="text-right">
			<a href="/snippets" class="btn btn-secondary">Go Back</a>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-xl">
		<form id="form-details" method="{{ $method }}" action="/snippets" data-redirect="@action" data-successMsg="true">
			<input type="hidden" name="id" value="{{ $record->id }}">

			<div class="form-group">
				<label>File</label>
				<input type="text" class="form-control" id="name" name="file" value="{{ $record->file }}">
			</div>

			<div class="form-group">
				<label>Key</label>
				<input type="text" class="form-control" id="key" name="key" value="{{ $record->key }}">
			</div>

			<div class="form-group">
				<label>Value</label>
				<input type="text" class="form-control" id="value" name="value" value="{{ $record->value }}">
			</div>

			<div class="text-right">
				<button class="js-submit btn btn-primary">Save</button>
			</div>

		</form>
	</div>
</div>

@endsection
