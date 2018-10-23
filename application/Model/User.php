<?php
class Model_User{
    public function __construct(){

    }

    public function index(){

    }

    public function getUser(){
        $this->createNewUser();
        return $this->getUserData();
    }

    private function createNewUser(){
        $sql_q = "INSERT INTO users SET id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$_SESSION['user_id']]);
    }

    private function getUserData(){
        $sql_q = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            $res['user_data'] = $st->fetch(PDO::FETCH_ASSOC);
            $res['status'] = 'success';
        }else{
            $res['status'] = 'error';
            $res['error_code'] = 3;
        }
        return $res;
    }
}