<?php
session_start();
ini_set('display_errors', 1);
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
function __autoload ($name) {
	list($folder,$class) = explode('_', $name);
	if(file_exists('application/'.$folder.'/'.$class.'.php')){
	    include   'application/'.$folder.'/'.$class.'.php';
    }
};

include 'application/config/config.php';
include 'application/bootstrap.php';
?>