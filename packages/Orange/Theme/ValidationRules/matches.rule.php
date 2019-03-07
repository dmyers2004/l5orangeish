<?php 

Validator::extend('matches', function ($attribute, $value, $parameters, $validator) {
  return ($value == $parameters[0]);
});

Validator::replacer('matches', function ($message, $attribute, $rule, $parameters) {
	return $attribute.' must match '.$parameters[0].'.';
});

/*
Test even if value is empty

Validator::extendImplicit('foo', function ($attribute, $value, $parameters, $validator) {
    return $value == 'foo';
});
*/