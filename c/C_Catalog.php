<?php

class C_Catalog extends C_Base
{
  public function action_index()
  {
    $this->title .= ' Каталог';
    $get_catalog = new M_Catalog();
    $this->content = $get_catalog->getProducts();

    $loader = new Twig_Loader_Filesystem('v');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('catalog.tmpl');
    $vars = array(
      'catalog' => $this->content
    );
    echo $template->render($vars);
  }
}
