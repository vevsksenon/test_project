<?php
class Model_UserData
{
    public function __construct(){

    }

    public function index(){

    }

    public function CreateNewUser(){
        $sql_q = "INSERT INTO users SET id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$_SESSION['user_id']]);
        if($st->rowCount()>0){
            return true;
        }
        return false;
    }

    public function GetUserData(){
        $res = array();
        $sql_q = "SELECT u.*,
                    my.max_energy_val,my.next_lvl_me_cost_money,my.next_lvl_me_cost_mineral,my.next_lvl_me_cost_cristal,
                    spe.seconds_per_energy_val,spe.next_lvl_spe_cost_money,spe.next_lvl_spe_cost_mineral,spe.next_lvl_spe_cost_cristal
                     FROM users AS u
                    LEFT JOIN max_energy AS my ON u.max_energy_lvl_id = my.max_energy_lvl
                    LEFT JOIN seconds_per_energy AS spe ON u.energy_per_sec_lvl_id = spe.seconds_per_energy_lvl
                    WHERE u.id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            $res['user_data'] = $st->fetch(PDO::FETCH_ASSOC);
            $res['status'] = 'success';
        }else{
            $res['status'] = 'error';
            $res['error_code'] = 6;
        }
        return $res;
    }

    public function SetEnergy($date){
        $set_date = date('Y-m-d H:i:s',$date);
        $sql_q = "UPDATE users SET last_update_energy = ? WHERE id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$set_date,$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function UpMaxEnergy(){
        $sql_q = "UPDATE users SET 
                    max_energy_lvl_id = max_energy_lvl_id+1                      
                    WHERE id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function UpSpeedEnergy(){
        $sql_q = "UPDATE users SET 
                    energy_per_sec_lvl_id = energy_per_sec_lvl_id+1                      
                    WHERE id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function Money($cost){
        $sql_q = "UPDATE users SET 
                    money = money+?                      
                    WHERE id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$cost,$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function Mineral($cost){
        $sql_q = "UPDATE users SET 
                    mineral = mineral+?                      
                    WHERE id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$cost,$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function Cristal($cost){
        $sql_q = "UPDATE users SET 
                    cristal = cristal+?                      
                    WHERE id = ?";
        $st = Common::$db->prepare($sql_q);
        $st->execute([$cost,$_SESSION['user_id']]);
        if($st->rowCount() > 0){
            return true;
        }
        return false;
    }
}