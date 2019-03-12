<?php

namespace Orange\Theme\Controllers;

use Orange\Core\BaseController\BaseController;
use Orange\Theme\Controllers\Traits\CrudTrait;

class SnippetsController extends BaseController
{
	use CrudTrait;

	protected $controller = 'Orange_snippets';
	protected $controller_path = '/snippets';
	protected $controller_model = \Orange\Theme\Models\Snippet::class;

	protected $controller_title = 'Snippet';
	protected $controller_titles = 'Snippets';

	protected $controller_index_order_by = 'key';
	protected $controller_index_limit = 2000;

} /* end class */
