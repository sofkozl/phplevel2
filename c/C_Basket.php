<?php

class C_Basket extends C_Base
{
  public function action_index()
  {
    $this->title .= '::Корзина';

    $get_user = new M_User();
    if (isset($_SESSION['id_user'])) {
      $user = $get_user->get($_SESSION['id_user']);
    } else {
      $user['user_name'] = false;
    }

    $get_basket = new M_Basket();
    $basket = $get_basket->index();
    $products = $basket[0];
    $basket_count = $basket[1];
    $basket_sum = $basket[2];

    $loader = new Twig_Loader_Filesystem('v');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('basket.tmpl');

    $vars = array(
      'title' => $this->title,
      'user' => $user['user_name'],
      'products' => $products,
      'basket_count' => $basket_count,
      'basket_sum' => $basket_sum
    );
    echo $template->render($vars);
  }

  public function action_add($id)
  {
    $product = new M_Basket($id);
    $add = $product->add($id);
    $backLink = $_SERVER["HTTP_REFERER"];
    header("location: $backLink");
  }

  public function action_delete()
  {
    $product = new M_Basket();
    $delete = $product->delete();
    $backLink = $_SERVER["HTTP_REFERER"];
    header("location: $backLink");
  }

  public function action_buy()
  {
    $product = new M_Basket();
    $buy = $product->buy();
    $backLink = $_SERVER["HTTP_REFERER"];
    header("location: $backLink");
  }
}
