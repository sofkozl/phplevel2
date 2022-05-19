<?php

define('DB_DRIVER', 'pgsql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'shop');
define('DB_USER', 'postgres');
define('DB_PASSWORD', '');

require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
  $connection = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
  $db = new PDO($connection, DB_USER, DB_PASSWORD);

  $rows = $db->exec("INSERT INTO catalog (name, description, price) VALUES
  ('Товар 1', 'Описание Товара 1', 1),
  ('Товар 2', 'Описание Товара 2', 2),
  ('Товар 3', 'Описание Товара 3', 3),
  ('Товар 4', 'Описание Товара 4', 4),
  ('Товар 5', 'Описание Товара 5', 5),
  ('Товар 6', 'Описание Товара 6', 6),
  ('Товар 7', 'Описание Товара 7', 7),
  ('Товар 8', 'Описание Товара 8', 8),
  ('Товар 9', 'Описание Товара 9', 9),
  ('Товар 10', 'Описание Товара 10', 10),
  ('Товар 11', 'Описание Товара 11', 11),
  ('Товар 12', 'Описание Товара 12', 12)
  ");

  if ($db->errorCode() != 0000) {
    $error_array = $db->errorInfo();
    echo 'SQL ошибка: ' . $error_array[2] . '<br/>';
  }

  if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
  } else {
    $limit = 3;
  }

  $result = $db->query("SELECT catalog.name AS name, catalog.description AS description, catalog.price AS price FROM catalog LIMIT $limit");

  $error_array = $db->errorInfo();

  if ($db->errorCode() != 0000) {
    echo 'SQL ошибка: ' . $error_array[2] . '<br/>';
  }

  $data = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('Error: ' . $e->getMessage());
}

try {
  // путь шаблонов
  $loader = new Twig_Loader_Filesystem('templates');

  // инициализ-ция Твиг
  $twig = new Twig_Environment($loader);

  // грузим шаблон
  $template = $twig->loadTemplate('catalog.tmpl');

  echo $template->render(array(
    'data' => $data,
    'count' => count($data)
  ));
} catch (Exception $e) {
  die('ERROR: ' . $e->getMessage());
}
