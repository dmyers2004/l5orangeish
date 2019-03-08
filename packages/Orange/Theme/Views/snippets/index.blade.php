@extends('orange-theme::_templates/default')

@section('content')

<div class="row">
	<div class="col-md">
		<h2>Manage Snippets</h2>
	</div>
	<div class="col-md">
		<div class="text-right">
			<a href="/snippets/create" class="btn btn-secondary">New</a>
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
			<td class="text-center">
				<a href="/snippets/{{ $record->id }}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<form class="delete-form" method="delete" action="/snippets/{{ $record->id }}" data-redirect="/snippets" data-confirm-text="Are you sure?">
					<a class="js-submit" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</form>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection
