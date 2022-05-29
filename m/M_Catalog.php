<?php

class M_Catalog
{
  public function getProducts()
  {
    $query = "SELECT * FROM products";
    $res = DB::Instance()->SelectAll($query);
    return $res;
  }
}
