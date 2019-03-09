@extends('orange-theme::_templates/default')

@section('content')

<div class="row">
	<div class="col-md">
		<h2>{{ $title }} Snippet</h2>
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
		<form method="" action="/snippets" data-redirect="@action" data-successMsg="true">

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right">File</label>
				<div class="col-sm-10">
      		<input type="text" readonly class="form-control-plaintext" value="{{ $record->file }}">
    		</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right">Key</label>
				<div class="col-sm-10">
      		<input type="text" readonly class="form-control-plaintext" value="{{ $record->key }}">
    		</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right">Value</label>
				<div class="col-sm-10">
      		<input type="text" readonly class="form-control-plaintext" value="{{ $record->value }}">
    		</div>
			</div>

		</form>
	</div>
</div>

@endsection
