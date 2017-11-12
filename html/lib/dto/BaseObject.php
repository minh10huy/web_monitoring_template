<?php
/**
 * Lớp cơ sở chứa câu lệnh thực thi query
 * @author ntvu_1
 */
class BaseObject {
    /**
    * Đây là câu lệnh query thực thi<br/>
    * Bất kì hành động nào liên quan tới database<br/>
    * &nbsp;&nbsp;&nbsp;nếu muốn theo dõi nó thì bạn sẽ cần tới việc<br/>
    * &nbsp;&nbsp;&nbsp;gán nó cho biến này.
    */
    var $sql;
    function __construct() {
        
    }
    public function getSql() {
        return $this->sql;
    }

    public function setSql($sql) {
        $this->sql = $sql;
    }
}

?>
