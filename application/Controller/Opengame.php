<?php
class Controller_OpenGame extends Controller{

    public function __construct(){
        parent::__construct();
        $this->checkAuth();
        $this->checkQuery(__CLASS__);
    }

    public function index(){
        $user = new Model_User();
        $this->data_response = $user->OpenGame();
        $this->answer();
        exit;
    }
}