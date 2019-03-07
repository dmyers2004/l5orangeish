<?php

namespace Orange\Core\Setting;

use Orange\Core\Model\Model;

class Setting extends Model
{
	protected $table = 'settings';
	protected $fillable = ['file','key','value'];
	protected $guarded = [];

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
