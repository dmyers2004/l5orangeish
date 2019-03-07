<?php 

Validator::extend('foo', function ($attribute, $value, $parameters, $validator) {
	dd(func_get_args());
	
	return $value == 'foo';
});
