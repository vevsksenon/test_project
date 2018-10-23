<?php
class Controller_Energylost extends Controller{

    public function __construct(){
        parent::__construct();
        $this->checkAuth();
        $this->checkQuery(__CLASS__);
    }

    public function index(){
        $user = new Model_User();
        $this->data_response = $user->LostEnergy();
        if($this->data_response['status'] == 'success'){
            $this->data_response = (new Model_UserData())->GetUserData();
        }
        $this->answer();
        exit;
    }
}