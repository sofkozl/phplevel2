<?php

include 'Twig/Autoloader.php';

spl_autoload_register('myAutoLoad');

function myAutoLoad($classname)
{
  $dirs = ['c', 'm'];
  $found = false;
  foreach ($dirs as $dir) {
    $filename = __DIR__ . '/' . $dir . '/' . $classname . '.php';

    if (is_file($filename)) {
      require_once($filename);
      $found = true;
      return true;
    }
  }
  if (!$found) {
    throw new Exception('Загрузка файла ' . $classname . ' не удалась.');
  }
}
