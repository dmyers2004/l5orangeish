<?php

namespace Orange\Core\Permission;

use Orange\Core\Model\Model;

class Permission extends Model
{
	protected $fillable = [];
	protected $guarded = [];

	public $timestamps = false;
	
	protected $rules = [
	];

	protected $ruleSets = [
	];

} /* end class */
