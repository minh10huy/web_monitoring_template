<?php
/**
 * Định nghĩa cấu trúc table Original<br/>
 *
 * @author ntvu_1
 */
class Original {

    //put your code here
    var $id;
    var $email_info_id;
    var $original_data;
    var $code;
    var $filepath; 
    function __construct() {
        
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmailInfoId() {
        return $this->email_info_id;
    }

    public function setEmailInfoId($email_info_id) {
        $this->email_info_id = $email_info_id;
    }

    public function getOriginalData() {
        return $this->original_data;
    }

    public function setOriginalData($original_data) {
        $this->original_data = $original_data;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function getFilepath() {
        return $this->filepath;
    }

    public function setFilepath($filepath) {
        $this->filepath = $filepath;
    }


}

?>
