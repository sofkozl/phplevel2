<?php

class M_Basket
{
  public function index()
  {
    $products = [];
    if (isset($_SESSION['basket'])) {
      $basket = $_SESSION['basket'];
      foreach ($basket as $key => $val) {
        $id_product = $key;
        $quantity = $val;
        $query = "SELECT * FROM products WHERE id_product=:id_product";
        $res = M_PDO::Instance()->Select($query, ['id_product' => $id_product]);
        foreach ($res as $key => $val) {
          $val['quantity'] = $quantity;
          $products[] = $val;
        }
      }
      $basket_count = 0;
      $basket_sum = 0;
      foreach ($products as $key => $val) {
        $basket_count += $val['quantity'];
        $basket_sum += $val['price'] * $val['quantity'];
      }
    }
    return array($products, $basket_count, $basket_sum);
  }

  public function add()
  {
    $id_product = intval($_GET['id']);
    $products = [];

    if (isset($_SESSION['basket'])) {
      $products = $_SESSION['basket'];
    }

    if (array_key_exists($id_product, $products)) {
      $products[$id_product]++;
    } else {
      $products[$id_product] = 1;
    }

    $_SESSION['basket'] = $products;
    return $products;
  }

  public function delete()
  {
    $id_product = $_GET['id'];
    unset($_SESSION['basket'][$id_product]);
  }

  public function buy()
  {
    if (isset($_SESSION['basket']) && isset($_SESSION['id_user'])) {
      $id_user = $_SESSION['id_user'];

      $query = "INSERT INTO order (id_user, datetime_create, id_order_status) VALUES (:id_user, :amount, :id_order_status)";
      $res = M_PDO::Instance()->Insert($query, ['id_user' => $id_user, 'datetime_create' => date("d/m/y"), 'id_order_status' => 1]);

      $id_order = M_PDO::Instance()->lastIndex();

      $products = $_SESSION['basket'];
      foreach ($products as $key => $val) {
        $id_product = $key;
        $quantity = $val;
        $query = "INSERT INTO order_products (id_order, id_product, quantity) VALUES (:id_order, :id_product, :quantity)";
        $res = M_PDO::Instance()->Insert($query, ['id_order' => $id_order, 'id_product' => $id_product, 'quantity' => $quantity]);
      }

      unset($_SESSION['basket']);
    }
  }

  public function count_items()
  {
    if (isset($_SESSION['basket'])) {
      $count = 0;
      foreach ($_SESSION['basket'] as $id => $quantity) {
        $count = $count + $quantity;
      }
      return $count;
    } else {
      return 0;
    }
  }

  public function get_products()
  {
    if (isset($_SESSION['basket'])) {
      return $_SESSION['basket'];
    }
    return false;
  }

  public function get_total_price()
  {
    $products = $this->get_products();

    if ($products) {
      $total = 0;
      foreach ($products as $item) {
        $total += $item['price'] * $products[$item['id']];
      }
    }

    return $total;
  }
}
