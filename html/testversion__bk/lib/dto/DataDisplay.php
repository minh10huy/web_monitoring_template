<?php

/**
 * Description of DataDisplay
 *
 * @author ntvu_1
 */
class DataDisplay {
    //put your code here
    var $original;
    var $arrRighCaptureData;
    var $username;
    
    function __construct() {
    }
    public function getOriginal() {
        return $this->original;
    }

    public function setOriginal($original) {
        $this->original = $original;
    }

    public function getArrRighCaptureData() {
        return $this->arrRighCaptureData;
    }

    public function setArrRighCaptureData($righCaptureData) {
        $this->arrRighCaptureData = $righCaptureData;
    }
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }
}

?>
