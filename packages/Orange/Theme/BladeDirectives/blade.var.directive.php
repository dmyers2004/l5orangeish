<?php

	/**
	 * @var('foo', 'test\' bar <strong>strong</strong>')
	 *
	 * <p>{!! $foo !!}</p>
	 */

Blade::directive('var', function ($expression) {
	$parts = str_getcsv($expression,',','\'');

	return "<?php $".ltrim($parts[0],'$')." = '".$parts[1]."'; ?>";
});
