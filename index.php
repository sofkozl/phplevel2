<?php

function myAutoLoad($classname)
{
	include_once("c/$classname.php");
}

spl_autoload_register('myAutoLoad');

//site.ru/index.php?act=auth&c=User

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

// switch ($_GET['c']) {
// 	case 'articles':
// 		$controller = new C_Page();
// 	case 'User':
// 		$controller = new C_User();
// 		break;
// 	default:
// 		$controller = new C_Page();
// }

if (isset($_GET['c'])) {
	if ($_GET['c'] == 'page') {
		$controller = new C_Page();
	} else if ($_GET['c'] == 'user') {
		$controller = new C_User();
	}
} else {
	$controller = new C_Page();
}

$controller->Request($action);
