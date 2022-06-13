<?php

class C_Catalog extends C_Base
{
  public function action_index()
  {
    $this->title .= '::Каталог';
    $get_catalog = new M_Catalog();
    $catalog = $get_catalog->getProducts();

    $loader = new Twig_Loader_Filesystem('v');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('catalog.tmpl');

    $vars = array(
      'title' => $this->title,
      'catalog' => $catalog
    );
    echo $template->render($vars);
  }

  public function action_product()
  {
    $get_product = new M_Catalog();
    $product = $get_product->getProduct();
    $this->title .= '::Каталог:: ' . $product['name'];

    $loader = new Twig_Loader_Filesystem('v');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('product.tmpl');
    $vars = array(
      'title' => $this->title,
      'product' => $product
    );
    echo $template->render($vars);
  }
}
