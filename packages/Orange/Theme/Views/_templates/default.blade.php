<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/assets/flash-msg/flash-msg.css">
		<link rel="stylesheet" href="/assets/rest-forms/rest-forms.css">
    <title>Hello, world!</title>
  </head>
  <body>
  	<div class="container">
			@yield('content')
		</div>
    <script>
			var messages = {!! $messages ?? '[]' !!};
		</script>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jStorage/0.4.12/jstorage.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="/assets/flash-msg/jquery.bootstrap.flash-msg.js"></script>
    <script src="/assets/rest-forms/rest-forms.js"></script>
  </body>
</html>
