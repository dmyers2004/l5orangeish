@extends('orange-theme::_templates/default')

@section('content')

<div class="row">
	<div class="col-md">
		<h2>Manage Snippets</h2>
	</div>
	<div class="col-md">
		<div class="text-right">
			@new_button('(.$controller_path.)/create','New Snippet')
		</div>
	</div>
</div>

<hr>

<table class="table table-striped table-hover">
	<thead class="thead-dark">
		<tr>
			<th class="text-center" scope="col">#</th>
			<th scope="col">Filename</th>
			<th scope="col">Key</th>
			<th scope="col">Value</th>
			<th class="text-center" scope="col">Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($records as $record)
		<tr>
			<th scope="row" class="text-center">{{ $record->id }}</th>
			<td>{{ $record->file }}</td>
			<td>{{ $record->key }}</td>
			<td>{{ $record->value }}</td>
			<td class="action text-center">
				@edit_button((.$controller_path.)/(.$record->id.)/edit)
				@delete_button((.$controller_path.)/(.$record->id.))
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection
