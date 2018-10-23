<?php
class Controller_User extends Controller{

    public function __construct(){
        parent::__construct();
        $this->checkAuth();
        $this->checkQuery(__CLASS__);
    }

    public function index(){
        $user = new Model_User();
        $this->data_response = $user->getUser();
        $this->answer();
        exit;
    }
}