<?php
class Controller{
    protected $data_response = null;
    protected $data_query = array();
	
	private $need_params = array(
	    'controller_user'              => array('su' => 'int', 'sa' => 'string'),
		'controller_opengame'          => array('su' => 'int', 'sa' => 'string'),
    );
	
    protected $errors =array(
		0 => 'unknown_error',
        1 => 'incorrect_params',
        2 => 'invalid_key',
        3 => 'user_not_exist',
		24 => 'no_auth',
		25 => 'error_connect_db',
		26 => 'method_does_not_exist',
    );

    public function __construct(){
        $this->data_query = $_GET;
    }
	
	public function checkAuth(){
		if(!Common::checkAuth() && !Common::checkAuthNoCookie()){
			$this->data_response['status'] = 'error';
			$this->data_response['error_code'] = 24;
			$this->answer();
		}
	}

    public function answer(){
		Common:: answer($this->data_response);
    }

	protected function checkQuery($class_name){
		$class_name = strtolower((string)$class_name);
	    if(!$this->checkParams($class_name)){
            $answer['status'] = 'error';
            $answer['error_code'] = 1;
            $this->data_response = $answer;
            $this->answer();
        }
    }

    private function checkParams($class_name){
		$class_name = strtolower((string)$class_name);
        if(!isset($this->need_params[$class_name])) return false;
		if(empty($this->need_params[$class_name])) return true;
        foreach($this->need_params[$class_name] as $var => $type){
            if(!isset($_REQUEST[$var])) return false;
            switch($type){
                case 'int':     if(!is_numeric($_REQUEST[$var])) return false;
                    $_REQUEST[$var] = (int)$_REQUEST[$var]; break;
                case 'double':  if(!is_double($_REQUEST[$var])) return false;
                    $_REQUEST[$var] = (int)$_REQUEST[$var]; break;
                case 'string':  if(!is_string($_REQUEST[$var])) return false;
                    break;
                case 'pattern_name': if(!Common::checkPatternName($_REQUEST[$var])) return false;
                    break;
                case 'arr':     if(!is_array($_REQUEST[$var]) || empty($_REQUEST[$var]))return false;
                    break;
            }
            $this->data_query[$var] = $_REQUEST[$var];
        }
        return true;
    }
}
?>