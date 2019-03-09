<?php

namespace Orange\Theme\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Orange\Theme\Controllers\Traits\CrudTrait;

class SnippetsController extends BaseController
{
	use CrudTrait;

	protected $controller = 'Orange_snippets';
	protected $controller_path = '/snippets';
	protected $controller_model = \Orange\Theme\Models\Snippet::class;
	protected $controller_title = 'Snippet';
	protected $controller_titles = 'Snippets';
	protected $controller_order_by = 'key';

} /* end class */
