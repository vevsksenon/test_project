<?php

class Route{

	public function __construct(){}
	
	public static function route_start(){

        $string = RURI;
		$arr_ruri = explode("/", $string);
		if(!isset($arr_ruri[2])){
		    $controller_name = 'Game';
		}else{
            $controller_name = $arr_ruri[2];
        }

		$controller_name = strtolower($controller_name);
		$controller_name = ucfirst($controller_name);
		if(file_exists('application/Controller/'.$controller_name.'.php')){
			$controller_name = 'Controller_'.$controller_name;
			Common::write_request($controller_name);
			$controller = new $controller_name;
			if(method_exists($controller, 'index')){
				$controller->index();
				exit;
			}
		}
		Common::answer(array('status' => 'error', 'error_code' => 26));
	}
}
?>