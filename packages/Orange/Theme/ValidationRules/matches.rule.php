<?php

/* actual rule matches:123,abc */
Validator::extend('matches', function ($attribute, $value, $parameters, $validator) {
  return ($value == $parameters[0]);
});

/* custom error message */
Validator::replacer('matches', function ($message, $attribute, $rule, $parameters) {
	return $attribute.' must match '.$parameters[0].'.';
});

/*
Run validation even if the value is empty

Validator::extendImplicit('foo', function ($attribute, $value, $parameters, $validator) {
    return $value == 'foo';
});
*/
