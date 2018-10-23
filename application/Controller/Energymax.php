<?php
class Controller_Energymax extends Controller{

    public function __construct(){
        parent::__construct();
        $this->checkAuth();
        $this->checkQuery(__CLASS__);
    }

    public function index(){
        $this->data_response = (new Model_User())->UpMaxEnergy();
        $this->answer();
        exit;
    }
}