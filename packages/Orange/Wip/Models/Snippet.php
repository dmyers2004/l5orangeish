<?php

namespace Orange\Wip\Models;

use Orange\Core\Model\Model;

class Snippet extends Model
{
	protected $fillable = ['file','key','value'];
	protected $guarded = [];
	protected $table = 'snippets';

	public $timestamps = false;
	
	protected $rules = [
		'id'=>'integer',
		'file'=>'required|string',
		'key'=>'required|string',
		'value'=>'nullable|string',
	];

	protected $ruleSets = [
		'store'=>'file,key,value',
		'update'=>'id,file,key,value',
	];

} /* end class */
