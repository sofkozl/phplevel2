<?php

trait singletonTrait
{
  private function __construct()
  {
  }

  public static function getInstance()
  {
    if (empty(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }
}

class Singleton
{
  use singletonTrait;

  private static $instance;

  public function doAction()
  {
  }
}

Singleton::getInstance()->doAction();
