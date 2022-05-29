<?php

include_once 'autoload.php';

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

if (isset($_GET['c'])) {
	if ($_GET['c'] == 'user') {
		$controller = new C_User();
	} else if ($_GET['c'] == 'catalog') {
		$controller = new C_Catalog();
	}
} else {
	$controller = new C_Catalog();
}

$controller->Request($action);
