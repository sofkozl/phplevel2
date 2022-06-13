<?php

session_start();

abstract class C_Controller
{
	// Генерация внешнего шаблона
	protected abstract function render();

	// Функция отрабатывающая до основного метода
	protected abstract function before();

	public function Request($action)
	{
		$this->before(); //метод вызывается до формирования данных для шаблон
		$this->$action();   //$this->action_index
		$this->render();
	}

	//
	// Запрос произведен методом GET?
	//
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	//
	// Запрос произведен методом POST?
	//
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
}
