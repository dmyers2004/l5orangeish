<?php 

Validator::extend('replace', function ($attribute, $value, $parameters, $validator) {
  dd(func_get_args());
  
  $value = str_replace($parameters[0],$parameters[1],$value);
  
  return true;
});
