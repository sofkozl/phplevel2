<?php

class C_Catalog extends C_Base
{
  public function action_index()
  {
    $this->title .= ' Каталог';
    $get_catalog = new M_Catalog();

    $loader = new Twig_Loader_Filesystem('v');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('index.tmpl');
    $catalog = $get_catalog->getProducts();

    $vars = array(
      'Каталог' => $this->title,
      'catalog' => $catalog
    );
    echo $template->render($vars);
  }
}
