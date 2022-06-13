<?php

include_once 'config/db.php';

class M_PDO
{
  private static $instance = null;

  private $db; // Ресурс работы с БД

  public static function Instance()
  {
    if (self::$instance == null) {
      self::$instance = new M_PDO();
    }
    return self::$instance;
  }

  private function __construct()
  {
    $this->db = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
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
  public function Select($query, $params = array())
  {
    $res = $this->Query($query, $params);
    if ($res) {
      return $res->fetch();
    }
  }

  /*
     * Выполнить запрос всех данных
     */
  public function SelectAll($query)
  {
    $res = $this->Query($query);
    if ($res) {
      return $res->fetchAll();
    }
  }


  /*
     * Поулчить следующую строку
     */
  public function GetRow($query, $params = array())
  {
    $res = $this->Query($query, $params);
    if ($res) {
      return $res->fetch();
    }
  }
  /*
     * Поулчить все строки
     */
  public function GetRows($query, $params = array())
  {
    $res = $this->Query($query, $params);
    if ($res) {
      return $res->fetchAll();
    }
  }

  /*
     * Вставить
     */
  public function Insert($query, $params = array())
  {
    $res = $this->Query($query, $params);
    if ($res) {
      return $this->db->lastInsertId();
    }
  }

  /*
     * Обновить
     */
  public function Update($query, $params = array())
  {
    $res = $this->Query($query, $params);
    if ($res) {
      return $res->rowCount();
    }
  }

  /*
     * Удалить
     */
  public function Delete($query, $params = array())
  {
    $res = $this->Query($query, $params);
    if ($res) {
      return $res->rowCount();
    }
  }

  public function lastIndex()
  {
    $index = $this->db->lastInsertId();
    return $index;
  }
}

/*
db::getInstance()->Select(
                'SELECT * FROM goods WHERE category_id = :category AND good_id=:good AND good_is_active=:status',
                ['status' => Status::Active, 'category' => $categoryId, 'good'=>$goodId]);
*/
