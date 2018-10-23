<?php
class Controller_User extends Controller{

    public function __construct(){
        parent::__construct();
        $this->checkAuth();
        $this->checkQuery(__CLASS__);
    }

    public function index(){
        $user_data = new Model_UserData();
        $this->data_response = $user_data->GetUserData();
        $this->answer();
        exit;
    }
}