<?php

abstract class Product
{
  const PROFIT = 0.1;

  abstract protected function getValue();
  abstract protected function getRevenue();
}

class digitalProduct extends Product
{
  const PRICE = 1000;
  public $qty;

  public function __construct($qty)
  {
    $this->qty = $qty;
  }

  public function getValue()
  {
    return self::PRICE * $this->qty;
  }

  public function getRevenue()
  {
    return $this->getValue() * parent::PROFIT;
  }
}

class pcsProduct extends digitalProduct
{
}

class weightProduct extends Product
{

  public $price;
  public $weight;

  public function __construct($price, $weight)
  {
    $this->price = $price;
    $this->weight = $weight;
  }

  public function getValue()
  {
    return $this->price * $this->weight;;
  }

  public function getRevenue()
  {
    return $this->getValue() * parent::PROFIT;
  }
}
