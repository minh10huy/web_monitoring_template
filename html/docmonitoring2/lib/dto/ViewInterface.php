<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Interface
 *
 * @author ntvu_1
 */
class ViewInterface {
    //put your code here
    var $username;
    var $original_id;
    var $original_data;
    var $right_id;
    var $right_data;
    var $right_code;
    var $capture_id;
    var $capture_data;
    var $capture_code;
    var $right_subcode;
    var $capture_subcode;
    var $status;
    var $note;
    var $stt;
    
    function __construct() {
        
    }
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getOriginalData() {
        return $this->original_data;
    }

    public function setOriginalData($original_data) {
        $this->original_data = $original_data;
    }

    public function getRightData() {
        return $this->right_data;
    }

    public function setRightData($right_data) {
        $this->right_data = $right_data;
    }

    public function getRightCode() {
        return $this->right_code;
    }

    public function setRightCode($right_code) {
        $this->right_code = $right_code;
    }

    public function getCaptureData() {
        return $this->capture_data;
    }

    public function setCaptureData($capture_data) {
        $this->capture_data = $capture_data;
    }

    public function getCaptureCode() {
        return $this->capture_code;
    }

    public function setCaptureCode($capture_code) {
        $this->capture_code = $capture_code;
    }

    public function getRightSubcode() {
        return $this->right_subcode;
    }

    public function setRightSubcode($right_subcode) {
        $this->right_subcode = $right_subcode;
    }

    public function getCaptureSubcode() {
        return $this->capture_subcode;
    }

    public function setCaptureSubcode($capture_subcode) {
        $this->capture_subcode = $capture_subcode;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($node) {
        $this->note = $node;
    }
    public function getStt() {
        return $this->stt;
    }

    public function setStt($stt) {
        $this->stt = $stt;
    }
    public function getOriginal_id() {
        return $this->original_id;
    }

    public function setOriginal_id($original_id) {
        $this->original_id = $original_id;
    }

    public function getRight_id() {
        return $this->right_id;
    }

    public function setRight_id($right_id) {
        $this->right_id = $right_id;
    }

    public function getCapture_id() {
        return $this->capture_id;
    }

    public function setCapture_id($capture_id) {
        $this->capture_id = $capture_id;
    }
}
?>
