<?php

/**
 *
 * return anchor($uri, '<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>', $attributes);
 * <a href="/snippets/{{ $record->id }}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
 * @new_button($controller_path.'/details','New Snippet')
 *
 */
Blade::directive('edit_button', function ($expression) {
	$html = '<a href="'.$expression.'"><i class="fa fa-pencil-square-o fa-lg"></i></a>';

	$html = str_replace("'","\'",$html);

	$html = str_replace(['(.','.)'],["'.",".'"],$html);

	return "<?php echo '".$html."'; ?>";
});
