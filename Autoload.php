<?php
function Autoload($class_name)
{
  if (empty($class_name)) {
    throw new Exception('Class name is empty');
  }

  $lib_path = dirname(__FILE__) . '/lib/';
  if (empty($lib_path)) {
    throw new Exception($lib_path . 'is empty');
  }

  $class_file = $lib_path . $class_name . ".php";

  if (is_file($class_file) && is_readable($class_file)) {
    require_once $class_file;
    if (!class_exists($class_name, false) && !interface_exists($class_name, false)) {
      throw new Exception("File '{$class_file}' was loaded but class '{$class_name}' was not found in file");
    }
  }
}

spl_autoload_register('Autoload');


