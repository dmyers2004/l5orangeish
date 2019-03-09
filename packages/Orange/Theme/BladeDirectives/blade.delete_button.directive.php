<?php

/**
 *
 * return anchor($uri, '<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>', $attributes);
 * <a href="/snippets/{{ $record->id }}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
 * @new_button($controller_path.'/details','New Snippet')
 *
 * <form method="delete" action="/snippets/{{ $record->id }}" data-after="destroy" data-confirm="true" data-successMsg="Record Deleted">
 *	<a class="js-submit" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
 * </form>
 */
Blade::directive('delete_button', function ($expression) {
	$html  = '<form method="delete" action="'.$expression.'" data-after="destroy" data-confirm="true" data-successMsg="Record Deleted">';
	$html .= '<a class="js-submit" href="#"><i class="fa fa-trash fa-lg"></i></a>';
	$html .= '</form>';

	$html = str_replace("'","\'",$html);
	$html = str_replace(['(.','.)'],["'.",".'"],$html);

	return "<?php echo '".$html."'; ?>";
});
