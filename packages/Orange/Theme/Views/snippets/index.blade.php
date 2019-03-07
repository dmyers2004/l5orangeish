@extends('orange-theme::_templates/default')

@section('content')
	<h1>Manage Snippets</h1>

	<table class="table table-striped">
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
	    	<td>
	    		

	    	</td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
@endsection
