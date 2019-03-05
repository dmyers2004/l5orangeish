<?php

Blade::directive('var', function ($expression) {
	$parts = str_getcsv($expression,',','\'');

	return "<?php $".ltrim($parts[0],'$')." = '".$parts[1]."'; ?>";
});
