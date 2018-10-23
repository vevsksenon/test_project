<?php
class Controller_Checkexmo extends Controller{

    public function __construct(){
        parent::__construct();
        //$this->checkAuth();
        //$this->checkQuery(__CLASS__);
    }

    public function index(){
        //$user_data = new Model_UserData();
        //$this->data_response = $user_data->GetUserData();
        //$this->answer();
        //exit;

        $url_1 = 'http://api.exmo.com/v1/currency/';

        $result1 = file_get_contents($url_1, false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query([])
            )
        )));
        $count = 1;
        $count = strlen($result1);

        if($count > 170 || ($count > 1 && $count < 170)){
            $sql_q = "SELECT count(*) FROM exmo";
            $st = Common::$db->prepare($sql_q);
            $st->execute([]);
            if($st->rowCount() > 0){
                $res = $st->fetch(PDO::FETCH_ASSOC);
                $res = $res['count(*)'];
                if($res <= 0){
                    $this->send(56494331,"Срочное сообщение!".$result1);
                    $sql_q = "INSERT INTO exmo SET send = 1";
                    $st = Common::$db->prepare($sql_q);
                    $st->execute([]);
                }
            }
        }
    }

    public function send($id , $message)
    {
        $url = 'https://api.vk.com/method/messages.send';
        $params = array(
            'user_id' => $id,    //
            'message' => $message,
            'access_token' => 'd79ee8672aca69bf116a2723d5059ecf7a7313eac2cfaad6779e4d1321cef6a8ab6260458cf4e9ba824cc',
            'v' => '5.37',
        );


        $result = file_get_contents($url, false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            )
        )));
    }
}