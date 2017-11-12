<?php

/**
 * Định nghĩa cấu trúc table RightCaptureData<br/>
 *
 * @author ntvu_1
 */
class RightCaptureData {

    //put your code here
    var $id;
    var $original_id;
    var $data;
    var $code;
    var $sub_code;
    var $is_right;
    var $note;
    
    function __construct() {
        
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getOriginal_id() {
        return $this->original_id;
    }

    public function setOriginal_id($original_id) {
        $this->original_id = $original_id;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function getSub_code() {
        return $this->sub_code;
    }

    public function setSub_code($sub_code) {
        $this->sub_code = $sub_code;
    }

    public function getIs_right() {
        return $this->is_right;
    }

    public function setIs_right($is_right) {
        $this->is_right = $is_right;
    }
    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }
}

?>
