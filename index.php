<?php

//1-4. Наследник отличается от родителя тем, что имеет специфические,
// свойственные только ему, свойства (обложка, кол-во страниц).
class Product
{
  public $name;
  public $price;
  public $origin;

  public function __construct($name, $price, $origin)
  {
    $this->name = $name;
    $this->price = $price;
    $this->origin = $origin;
  }

  public function info()
  {
    return "Наименование товара: $this->name, страна производства $this->origin, цена $this->price рублей";
  }
}

class BookProduct extends Product
{
  public $pages;
  public $cover;

  public function __construct($name, $price, $origin, $pages, $cover)
  {
    parent::__construct($name, $price, $origin);
    $this->pages = $pages;
    $this->cover = $cover;
  }

  public function getNumberOfPages()
  {
    return $this->pages;
  }
}


//5. Выведет 1,2,3,4: оператор инкремента ++ находится слева от статической переменной $x, 
// то есть значение сначала увеличивается на 1, потом происходит возврат увеличенного значения.
// Класс А содержит статическую переменную, т.е. находится в области видимости самого класса,
// а не его экземпляров.

class A
{
  public function foo()
  {
    static $x = 0;
    echo ++$x;
  }
}
$a1 = new A();
$a2 = new A();
$a1->foo();
$a2->foo();
$a1->foo();
$a2->foo();

//6. Выведет 1,1,2,2: оператор инкремента ++ находится слева от статической переменной $x, 
// то есть значение сначала увеличивается на 1, потом происходит возврат увеличенного значения.
// Класс B наследует метод foo() у класса A, но области видимости статической переменной $x у двух классов будут
//различны. 

class A
{
  public function foo()
  {
    static $x = 0;
    echo ++$x;
  }
}
class B extends A
{
}
$a1 = new A();
$b1 = new B();
$a1->foo();
$b1->foo();
$a1->foo();
$b1->foo();
