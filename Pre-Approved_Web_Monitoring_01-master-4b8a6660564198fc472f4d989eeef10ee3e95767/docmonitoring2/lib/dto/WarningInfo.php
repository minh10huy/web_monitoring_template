<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WarningInfo
 *
 * @author ntvu_1
 */
class WarningInfo {
    //put your code here
    var $time;
    var $proj_name;
    var $warning_msg;
    var $btn_html;
    var $len_data;
    var $date_index;
    
    public function getTime() {
        return $this->time;
    }

    public function getProj_name() {
        return $this->proj_name;
    }

    public function getWarning_msg() {
        return $this->warning_msg;
    }

    public function getBtn_html() {
        return $this->btn_html;
    }

    public function getLen_data() {
        return $this->len_data;
    }

    public function getDate_index() {
        return $this->date_index;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function setProj_name($proj_name) {
        $this->proj_name = $proj_name;
    }

    public function setWarning_msg($warning_msg) {
        $this->warning_msg = $warning_msg;
    }

    public function setBtn_html($btn_html) {
        $this->btn_html = $btn_html;
    }

    public function setLen_data($len_data) {
        $this->len_data = $len_data;
    }

    public function setDate_index($date_index) {
        $this->date_index = $date_index;
    }


}
