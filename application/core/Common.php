<?php

class Common{

    public static $db;
    private static $query_id = null;
    public static $settings = array();
    public static $settings_secure = array();
	private static $query_params_log = null; 

	public function __construct(){
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
        $user = DB_USER;
        $password = DB_PASS;
        try {
            self::$db = new PDO($dsn,$user,$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
            $sql_q = "SELECT * FROM system_setting";
            $st = self::$db->prepare($sql_q);
            $st->execute();
            if($st->rowCount()){
                while($row = $st->fetch(PDO::FETCH_ASSOC)){
                    if($row['secure'] == 1){
                        self::$settings_secure[$row['option']] = $row['val'];
                    }else{
                        self::$settings[$row['option']] = $row['val'];
                    }
                }
            }
        } catch (PDOException $e) {
            self::answer(array('status' => 'error', 'error_code' => 25));
        }
	}
	
	public static function checkAuthNoCookie(){
		if(isset($_REQUEST['su'], $_REQUEST['sa'])){
			$user_id = (int)$_REQUEST['su'];
			if(self::checkAuthKey($_REQUEST['su'], $_REQUEST['sa'])){
				$_SESSION['user_id'] = $user_id;
				return true;
			}
		}
		return false;
	}
	
	public static function checkAuthKey($user_id, $auth_key){
		$secret_key = self::$settings_secure['application_secret'];
		$app_id = self::$settings_secure['application_id'];
		return ($auth_key === md5($app_id.'_'.$user_id.'_'.$secret_key)) ? true : false;
	}
	
	public static function checkAuth(){
		return isset($_SESSION['user_id']) ? true : false;
	}

	public static function write_request($method){
        $query_request['method'] = $method;
        $query_request = array_merge($query_request, $_REQUEST);
        $query_request = json_encode($query_request);
		self::$query_params_log = $query_request;
//       $sql_q = "INSERT INTO bv_query (query_request, query_time) VALUES (?,NOW());";
//        $st = self::$db->prepare($sql_q);
//        $st->execute(array($query_request));
//        self::$query_id = Common::$db->lastInsertId();
    }

    public static function write_response($json){
		if(!empty(self::$query_params_log)){
			$sql_q = "INSERT INTO err_query (query_request, query_time, query_response) VALUES (?,NOW(), ?);";
			$st = self::$db->prepare($sql_q);
			$st->execute(array(self::$query_params_log, $json));
		}
    }
	
	public static function answer($data_response){
		$data_response['time'] = date('Y-m-d H:i:s', time());
		$error = false;
		if(isset($data_response['status']) && $data_response['status'] == 'error'){
			$error = true;
		}
        $answer = json_encode($data_response);
		if($error){
		    Common::write_response($answer);
		}
        echo $answer;
        exit;
	}

	public static function checkPatternName($value){
        $value = trim($value);
	    return preg_match('/^[\w\s]{3,16}$/u', $value);
    }
}

?>