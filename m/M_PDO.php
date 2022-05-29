<?php

include_once 'config/db.php';

class DB
{
  private static $instance = null;

  private $db; // Ресурс работы с БД

  public static function Instance()
  {
    if (self::$instance == null) {
      self::$instance = new DB();
    }
    return self::$instance;
  }

  private function __construct()
  {
    $this->db = new PDO(DB_DRIVER . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $this->db->exec('SET NAMES UTF8');
    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }
  private function __sleep()
  {
  }
  private function __wakeup()
  {
  }
  private function __clone()
  {
  }
  /*
     * Выполнить запрос к БД
     */
  private function Query($query, $params = array())
  {
    $res = $this->db->prepare($query);
    $res->execute($params);

    if ($res->errorCode() != PDO::ERR_NONE) {
      $info = $res->errorInfo();
      die($info[2]);
    }
    return $res;
  }

  /*
     * Выполнить запрос с выборкой данных
     */
  public static function Select($query, $params = array())
  {
    return self::Query($query, $params)->fetchAll();
  }

  /*
     * Выполнить запрос всех данных
     */
  public static function SelectAll($query)
  {
    return self::Query($query)->fetchAll();
  }


  /*
     * Поулчить следующую строку
     */
  public static function GetRow($query, $params = array())
  {
    return self::Query($query, $params)->fetch();
  }

  /*
     * Вставить
     */
  public static function Insert($query, $params = array())
  {
    return self::Query($query, $params)->lastInsertId();
  }

  /*
     * Обновить
     */
  public static function Update($query, $params = array())
  {
    return self::Query($query, $params)->rowCount();
  }

  /*
     * Удалить
     */
  public static function Delete($query, $params = array())
  {
    return self::Query($query, $params)->rowCount();
  }
}

/*
db::getInstance()->Select(
                'SELECT * FROM goods WHERE category_id = :category AND good_id=:good AND good_is_active=:status',
                ['status' => Status::Active, 'category' => $categoryId, 'good'=>$goodId]);
*/
