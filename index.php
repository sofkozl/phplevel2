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
  $template = $twig->loadTemplate('index.tmpl');

  $photos = array_slice(scandir(PHOTO_BIG), 2);

  echo $template->render(array(
    'title' => 'Галерея',
    'photo_small' => PHOTO_SMALL,
    'photos' => $photos
  ));
} catch (Exception $e) {
  die('ERROR: ' . $e->getMessage());
}
