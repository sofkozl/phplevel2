<?php

class M_Catalog
{
  public $id_product, $name, $image, $price;

  public function getProducts()
  {
    $query = "SELECT * FROM products";
    $res = M_PDO::Instance()->SelectAll($query);
    return $res;
  }
}
