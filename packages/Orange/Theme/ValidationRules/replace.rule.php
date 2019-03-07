<?php 

/* filter */

Validator::extend('replace', function ($attribute, $value, $parameters, $validator) {
  $all_data = $validator->getData();
  
  $all_data[$attribute] = str_replace($parameters[0],$parameters[1],$all_data[$attribute]);
  
  $validator->setData($all_data);
  
  return true;
});
