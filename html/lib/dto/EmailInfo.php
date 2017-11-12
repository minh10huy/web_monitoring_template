<?php
/**
 * Định nghĩa cấu trúc table EmailInfo<br/>
 *
 * @author ntvu_1
 */
class EmailInfo {
    //put your code here
    var $id;
    var $username;
    var $subject;
    var $date_receive;
    var $old_rating;
    var $new_rating;
    
    function __construct() {
        
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getDateReceive() {
        return $this->date_receive;
    }

    public function setDateReceive($date_receive) {
        $this->date_receive = $date_receive;
    }

    public function getOldRating() {
        return $this->old_rating;
    }

    public function setOldRating($old_rating) {
        $this->old_rating = $old_rating;
    }

    public function getNewRating() {
        return $this->new_rating;
    }

    public function setNewRating($new_rating) {
        $this->new_rating = $new_rating;
    }
}
?>
