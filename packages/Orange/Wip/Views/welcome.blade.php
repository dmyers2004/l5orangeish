@extends('layouts.app')

@section('content')
<div class="container">
 my welcome blade.

	@var('foo', 'test\' bar <strong>strong</strong>')

	<p>{!! $foo !!}</p>

 </div>
@endsection
