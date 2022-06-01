<?php

/**
 * Основной шаблон
 * ===============
 * $title - заголовок
 * $content - HTML страницы
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title><?= $title ?></title>
	<meta content="text/html; charset=Windows-1251" http-equiv="content-type">
	<link rel="stylesheet" type="text/css" media="screen" href="v/style.css" />
</head>

<body>
	<div id="header">
		<h1><?= $title ?></h1>
	</div>

	<div id="menu">
		<a href="index.php">Читать текст</a> |
		<a href="index.php?c=page&act=edit">Редактировать текст</a>
		<?php
		if ($user) {
			echo '<a href="index.php?c=user&act=info">Личный кабинет</a> | <a href="index.php?c=user&act=logout">Выйти</a>';
		} else {
			echo '<a href="index.php?c=user&act=auth">Войти</a> | <a href="index.php?c=user&act=register">Регистрация</a>';
		}
		?>
	</div>

	<div id="content">
		<?= $content ?>
	</div>

	<div id="footer">
		Все права защищены. Адрес. Телефон.
	</div>
</body>

</html>