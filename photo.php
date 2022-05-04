<?php

const PHOTO_BIG = 'gallery_img/big';
const PHOTO_SMALL = 'gallery_img/small';

require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
  // путь шаблонов
  $loader = new Twig_Loader_Filesystem('templates');

  // инициализ-ция Твиг
  $twig = new Twig_Environment($loader);

  // грузим шаблон
  $template = $twig->loadTemplate('photo.tmpl');

  $photo = stripcslashes($_GET['photo']);

  if (!file_exists(PHOTO_BIG . '/' . $photo)) {
    throw new Exception('Такого файла не существует');
  }

  echo $template->render(array(
    'title' => 'Галерея',
    'photo_big' => PHOTO_BIG,
    'photo' => $photo
  ));
} catch (Exception $e) {
  die('ERROR: ' . $e->getMessage());
}
