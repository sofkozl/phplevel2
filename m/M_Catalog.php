<?php

class M_Catalog
{

  public function getProducts()
  {
    $query = "SELECT * FROM products";
    $res = M_PDO::Instance()->SelectAll($query);
    return $res;
  }

  public function getProduct()
  {
    $id_product = $_GET['id'];
    $query = "SELECT * FROM products WHERE id_product=:id_product";
    $res = M_PDO::Instance()->Select($query, ['id_product' => $id_product]);
    return $res;
  }
}
