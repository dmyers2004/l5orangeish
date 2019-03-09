<?php

/**
 *
 * <?=pear::new_button($controller_path.'/details','New Snippet') ?>
 *
 * @new_button($controller_path.'/details','New Snippet')
 *
 */
Blade::directive('new_button', function ($expression) {
	$parts = str_getcsv($expression,',','\'');

	$html = '<a href="'.$parts[0].'" class="btn btn-outline-primary btn-sm js-new"><i class="fa fa-magic" aria-hidden="true"></i> '.$parts[1].'</a>';

	$html = str_replace("'","\'",$html);
	$html = str_replace(['(.','.)'],["'.",".'"],$html);

	return "<?php echo '".$html."'; ?>";
});
