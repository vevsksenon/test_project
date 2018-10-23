<?php
class Model_User{
    public function __construct(){

    }

    public function index(){

    }

    public function OpenGame(){
        $user_data = new Model_UserData();
        $user_data->CreateNewUser();
        $data = $user_data->GetUserData();
        return $data;
    }

    public function LostEnergy($lost_count = 1){
        $user_data = new Model_UserData();
        $data = $user_data->GetUserData();
        if($data['status'] == 'error'){
            return $data;
        }
        $max_energy = $data['user_data']['max_energy_val'];
        $current_time = time();
        $last_update = strtotime($data['user_data']['last_update_energy']);
        $second_to_one_energy = $data['user_data']['seconds_per_energy_val'];
        $time_difference = $current_time-$last_update;

        if($time_difference < $lost_count*$second_to_one_energy){
            $data1['status'] = 'error';
            $data1['error_code'] = 3;
            return $data1;
        }

        $total_max_energy = $max_energy*$second_to_one_energy;
        if($time_difference > $total_max_energy){
            $time_difference = $total_max_energy;
        }

        $new_last_update = ($current_time-$time_difference)+($lost_count*$second_to_one_energy);
        if(!$user_data->SetEnergy($new_last_update)){
            $data1['status'] = 'error';
            $data1['error_code'] = 7;
            return $data1;
        }
        $data1['status'] = 'success';
        return $data1;
    }

    public function UpMaxEnergy(){
        $user_data = new Model_UserData();
        $data = $user_data->GetUserData();
        if($data['status'] == 'error'){
            return $data;
        }
        if($data['user_data']['max_energy_lvl_id'] == Common::$settings['max_energy_lvl']){
            $res['status'] = 'error';
            $res['error_code'] = 11;
            return $res;
        }
        
        $max_energy = $data['user_data']['max_energy_val'];
        $last_update = strtotime($data['user_data']['last_update_energy']);
        $second_to_one_energy = $data['user_data']['seconds_per_energy_val'];

        $money = $data['user_data']['money'];
        $mineral = $data['user_data']['mineral'];
        $cristal = $data['user_data']['cristal'];

        $cost_money = $data['user_data']['next_lvl_me_cost_money'];
        $cost_mineral = $data['user_data']['next_lvl_me_cost_mineral'];
        $cost_cristal = $data['user_data']['next_lvl_me_cost_cristal'];
        if($money >= $cost_money && $mineral >= $cost_mineral && $cristal >= $cost_cristal){
            if($this->SetNewLastUpdate($max_energy,$last_update,$second_to_one_energy)){
                if($user_data->UpMaxEnergy()){
                    $process = true;
                    if($cost_money != 0 && $process){
                        if(!$this->UpdateMoney($cost_money,false)){
                            $process = false;
                        }
                    }
                    if($cost_mineral != 0 && $process){
                        if(!$this->UpdateMineral($cost_mineral,false)){
                            $process = false;
                        }
                    }
                    if($cost_cristal != 0 && $process){
                        if(!$this->UpdateCristal($cost_cristal,false)){
                            $process = false;
                        }
                    }
                    if($process){
                        $data = $user_data->GetUserData();
                        return $data;
                    }else{
                        $res['status'] = 'error';
                        $res['error_code'] = 5;
                    }
                }else{
                    $res['status'] = 'error';
                    $res['error_code'] = 5;
                }
            }else{
                $res['status'] = 'error';
                $res['error_code'] = 5;
            }
        }else{
            $res['status'] = 'error';
            $res['error_code'] = 4;
        }
        return $res;
    }

    public function SetNewLastUpdate($max,$last,$sec_e){
        $current_time = time();
        $time_diff = $current_time-$last;

        $user_data = new Model_UserData();

        if($time_diff >= $max*$sec_e){
            $new_time = $current_time-$max*$sec_e;
            if($user_data->SetEnergy($new_time)){
                return true;
            }
        }
        return true;
    }

    public function SetNewLastUpdateSpeed($max,$last,$sec_e){
        $user_data = new Model_UserData();
        $current_time = time();
        $time_diff = $current_time-$last;
        $count_time = floor($time_diff/$sec_e);
        if($count_time >= $max){
            $count_time = $max;
        }
        $new_time = $current_time-$time_diff+$count_time*10;

        if($user_data->SetEnergy($new_time)){
            return true;
        }
        return false;
    }

    public function UpSpeedEnergy(){
        $user_data = new Model_UserData();
        $data = $user_data->GetUserData();
        if($data['status'] == 'error'){
            return $data;
        }
        if($data['user_data']['energy_per_sec_lvl_id'] == Common::$settings['max_speed_energy_lvl']){
            $res['status'] = 'error';
            $res['error_code'] = 10;
            return $res;
        }

        $max_energy = $data['user_data']['max_energy_val'];
        $last_update = strtotime($data['user_data']['last_update_energy']);
        $second_to_one_energy = $data['user_data']['seconds_per_energy_val'];

        $money = $data['user_data']['money'];
        $mineral = $data['user_data']['mineral'];
        $cristal = $data['user_data']['cristal'];

        $cost_money = $data['user_data']['next_lvl_spe_cost_money'];
        $cost_mineral = $data['user_data']['next_lvl_spe_cost_mineral'];
        $cost_cristal = $data['user_data']['next_lvl_spe_cost_cristal'];
        if($money >= $cost_money && $mineral >= $cost_mineral && $cristal >= $cost_cristal){
            if($this->SetNewLastUpdateSpeed($max_energy,$last_update,$second_to_one_energy)){
                if($user_data->UpSpeedEnergy()){
                    $process = true;
                    if($cost_money != 0 && $process){
                        if(!$this->UpdateMoney($cost_money,false)){
                            $process = false;
                        }
                    }
                    if($cost_mineral != 0 && $process){
                        if(!$this->UpdateMineral($cost_mineral,false)){
                            $process = false;
                        }
                    }
                    if($cost_cristal != 0 && $process){
                        if(!$this->UpdateCristal($cost_cristal,false)){
                            $process = false;
                        }
                    }
                    if($process){
                        $data = $user_data->GetUserData();
                        return $data;
                    }else{
                        $res['status'] = 'error';
                        $res['error_code'] = 8;
                    }
                }else{
                    $res['status'] = 'error';
                    $res['error_code'] = 8;
                }
            }else{
                $res['status'] = 'error';
                $res['error_code'] = 8;
            }
        }else{
            $res['status'] = 'error';
            $res['error_code'] = 9;
        }
        return $res;
    }

    public function UpdateMoney($count,$up_balance){
        if(!$up_balance){
            $count = -$count;
        }
        $user = new Model_UserData();
        if($user->Money($count)){
            return true;
        }else{
            return false;
        }
    }

    public function UpdateMineral($count,$up_balance){
        if(!$up_balance){
            $count = -$count;
        }
        $user = new Model_UserData();
        if($user->Mineral($count)){
            return true;
        }else{
            return false;
        }
    }

    public function UpdateCristal($count,$up_balance){
        if(!$up_balance){
            $count = -$count;
        }
        $user = new Model_UserData();
        if($user->Cristal($count)){
            return true;
        }else{
            return false;
        }
    }
}