<?php
function __autoload($className) {
	if (file_exists('classes/' . $className . '.class.php')) {
		require_once 'classes/'. $className . '.class.php';
		return true;
	} else if (file_exists('../classes/' . $className . '.class.php')){
		require_once '../classes/'. $className . '.class.php';
		return true;
	} else if (file_exists('../../classes/' . $className . '.class.php')){
		require_once '../../classes/'. $className . '.class.php';
		return true;
	} else {
		echo "Class kan niet worden gevonden";
	}
	return false;
}
?>