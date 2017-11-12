<?php
/**
 * Định nghĩa cấu trúc table EmailContent<br/>
 *
 * @author ntvu_1
 */
class EmailContent {

    //put your code here
    var $id;
    var $email_info_id;
    var $testrundid;
    var $dragset;
    var $start_time;
    var $end_time;
    var $results_from_manual;
    var $master_green_strings;
    var $correct_green_strings;
    var $rating_for_test_run;
    var $delta_file;

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

    public function getTestrundId() {
        return $this->testrundid;
    }

    public function setTestrundId($testrundid) {
        $this->testrundid = $testrundid;
    }

    public function getDragset() {
        return $this->dragset;
    }

    public function setDragset($dragset) {
        $this->dragset = $dragset;
    }

    public function getStartTime() {
        return $this->start_time;
    }

    public function setStartTime($start_time) {
        $this->start_time = $start_time;
    }

    public function getEndTime() {
        return $this->end_time;
    }

    public function setEndTime($end_time) {
        $this->end_time = $end_time;
    }

    public function getResultsFromManual() {
        return $this->results_from_manual;
    }

    public function setResultsFromManual($results_from_manual) {
        $this->results_from_manual = $results_from_manual;
    }

    public function getMasterGreenStrings() {
        return $this->master_green_strings;
    }

    public function setMasterGreenStrings($master_green_strings) {
        $this->master_green_strings = $master_green_strings;
    }

    public function getCorrectGreenStrings() {
        return $this->correct_green_strings;
    }

    public function setCorrectGreenStrings($correct_green_strings) {
        $this->correct_green_strings = $correct_green_strings;
    }

    public function getRatingForTestRun() {
        return $this->rating_for_test_run;
    }

    public function setRatingForTestRun($rating_for_test_run) {
        $this->rating_for_test_run = $rating_for_test_run;
    }

    public function getDeltaFile() {
        return $this->delta_file;
    }

    public function setDeltaFile($delta_file) {
        $this->delta_file = $delta_file;
    }


}

?>
