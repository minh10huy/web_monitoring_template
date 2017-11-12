<?php

class LookupChannelDataDAO {
    //put your code here
    function __construct() {
        
    }

    public function getChannels($rows, $offset, $filter, $sort, $order, $id = NULL){
        $conn = PostgreSQLClass::getConn();
        
        $where = " WHERE lower(lc.company) like 'vpbank' AND lc.cc_role NOT IN ('admin', 'subadmin', 'manager')";
        if (!is_null($id)) {
            $where .= " AND lc.cc_role != 'supervisor' AND lc.parent_id = ".$id;
        }
        
        if (strlen($filter) > 0) {
            $where .= " AND (lower(lc.cc_code) like lower('%$filter%') or lower(lc.channel) like lower('%$filter%') or lower(lc.province) like lower('%$filter%') or lower(lc.pos_code) like lower('%$filter%') or lower(lc.pos_name) like lower('%$filter%') or lower(lc.cc_role) like lower('%$filter%'))";
        }
       
        $rs = pg_query("select count(*) from db_16001_0001_bak_20160525.lookup_channel lc" . $where);
        $row = pg_fetch_row($rs);
        $result["total"] = $row[0];
        
        //$sort = "lc.".$sort;
        $select = "SELECT lc.id, lc.cc_code, lc.channel, lc.province, lc.pos_code, lc.pos_name, lc.cc_name, lc.cc_role, (CASE WHEN lc.is_android = 0 THEN 'No' ELSE 'Yes' END) as is_android, (CASE WHEN la.is_blocked IS NULL OR la.is_blocked = 0 THEN 'No' ELSE 'Blocked' END) as blocked FROM db_16001_0001_bak_20160525.lookup_channel lc LEFT OUTER JOIN db_16001_0001_bak_20160525.login_attempts la ON lc.cc_code = la.username" . $where . " order by {$sort} {$order} limit {$rows} offset {$offset}";
        // declare my query and execute
        $rs = pg_query($conn, $select);
        //$error = pg_last_error(); 
        // process results
        $items = array();
        
        while ($row = pg_fetch_object($rs)) {
            array_push($items, $row);
        }
       $result["rows"] = $items;
       $conn . close;
        return $result;
        
    }
    
    public function checkDuplicateCCCode($cc_code) {
        $conn = PostgreSQLClass::getConn();
        // declare my query and execute
        $rs = pg_query("select count(*) from db_16001_0001_bak_20160525.lookup_channel WHERE cc_code = '".$cc_code . "'");
        $row = pg_fetch_row($rs);
        $conn . close;
        
        if (!$rs || $row[0] > 0)
            return true;

        return false;
    }
    
    public function insertChannels($cc_code, $channel, $province, $pos_code, $pos_name, $cc_role, $cc_name, $parent_id, $mobile, $create_user){
        $conn = PostgreSQLClass::getConn();
        // declare my query and execute
        $select = "insert into db_16001_0001_bak_20160525.lookup_channel(cc_code, channel, province, company, pos_code, pos_name, cc_role, cc_name, parent_id, is_android, date_of_user_creation, creator) values('$cc_code', '$channel', '$province', 'vpbank' ,'$pos_code', '$pos_name', '$cc_role', '$cc_name', $parent_id, $mobile, NOW(), '$create_user')";
       
        $query = $select;
//        echo $query;exit();
        $result = pg_query($conn, $query);
        $conn . close;
        
        if (!$result) {
            return false;
        }
        
        return true;
    }
    
    
     public function updateChannels($id, $cc_code, $channel, $province, $pos_code, $pos_name, $cc_role, $cc_name, $parent_id, $android){
        $conn = PostgreSQLClass::getConn();
        // declare my query and execute
        $select = "update db_16001_0001_bak_20160525.lookup_channel set cc_code = '$cc_code', channel = '$channel', province = '$province', company = 'vpbank' ,pos_code = '$pos_code', pos_name = '$pos_name', cc_role = '$cc_role', cc_name = '$cc_name', parent_id = $parent_id, is_android = $android";
        
        $where = " WHERE id = ".$id;
        $query = $select . $where;
//        echo $query;exit();
        $result = pg_query($conn, $query);
        $conn . close;
        
        if (!$result) {
            return false;
        }
        
        return true;
    }
    
     public function unblockChannels($username){
        $conn = PostgreSQLClass::getConn();
        
        $rs = pg_query($conn, "select count(*) from db_16001_0001_bak_20160525.login_attempts where is_blocked = 1 and username = '$username'");
        $unblock_user = pg_fetch_row($rs);
        if ($unblock_user && intval($unblock_user[0]) > 0) {
            // declare my query and execute
            $update = "update db_16001_0001_bak_20160525.login_attempts set is_blocked = 0 where username = '$username'";

    //        echo $query;exit();
            $result = pg_query($conn, $update);
            
        } else {
            $result = false;
        }

        
        $conn . close;
        
        if (!$result) {
            return false;
        }
        
        return true;
    } 
    
    public function resetChannels($username) {
        $conn = PostgreSQLClass::getConn();


        // declare my query and execute
        $update = "update db_16001_0001_bak_20160525.lookup_channel set cc_password = md5('saigonbpo@123') where cc_code = '$username'";

        //        echo $query;exit();
        $result = pg_query($conn, $update);

        $conn . close;

        if (!$result) {
            return false;
        }

        return true;
    }

    public function deleteChannels($id){
        $conn = PostgreSQLClass::getConn();
        // declare my query and execute
        $select = "delete from db_16001_0001_bak_20160525.lookup_channel where id = $id";
        
        $query = $select;
//        echo $query;exit();
        $result = pg_query($conn, $query);
        $conn . close;
        
        if (!$result) {
            return false;
        }
        
        return true;
    }
	
    public function checkDuplicateIMEI($imei_no) {
        $conn = PostgreSQLClass::getConn();
        // declare my query and execute
        $rs = pg_query("select count(*) from db_16001_0001_bak_20160525.register_device WHERE device_imei = '".$imei_no . "'");
        $row = pg_fetch_row($rs);
        $conn . close;
        
        if (!$rs || $row[0] > 0)
            return true;

        return false;
    }
    
    public function insertIMEI($device_model, $imei_no, $notes){
        $conn = PostgreSQLClass::getConn();
        // declare my query and execute
        $select = "insert into db_16001_0001_bak_20160525.register_device(device_model, device_imei, notes) values('$device_model', '$imei_no', '$notes')";
       
        $query = $select;
//        echo $query;exit();
        $result = pg_query($conn, $query);
        $conn . close;
        
        if (!$result) {
            return false;
        }
        
        return true;
    } 

    public function getDataReport($channel){
        $conn = PostgreSQLClass::getConn();
        
        $where = " WHERE lower(lc1.company) like 'vpbank' AND lc1.cc_role NOT IN ('admin', 'subadmin', 'manager')";
        if ($channel != 'All') {
            $where .= " AND channel = '".$channel. "'";
        }
        
        $select = "SELECT   lc1.cc_code, 
                            lc1.channel, lc1.province, 
                            lc1.pos_code, lc1.pos_name, 
                            lc1.cc_name, lc1.cc_role, 
                            (CASE WHEN lc1.is_android = 0 THEN 'No' ELSE 'Yes' END) as mobile, 
                            lc2.cc_code as direct_manager, lc2.cc_name as manager_name   
                    FROM db_16001_0001_bak_20160525.lookup_channel lc1 
                    JOIN (SELECT id, cc_code, cc_name FROM db_16001_0001_bak_20160525.lookup_channel) lc2 ON lc1.parent_id = lc2.id";
        // declare my query and execute
        $rs = pg_query($conn, $select.$where);
        //$error = pg_last_error(); 
        // process results
        $items = array();
        
        while ($row = pg_fetch_object($rs)) {
            array_push($items, $row);
        }
       $result = $items;
       $conn . close;
        return $result;
        
    }    	
}
?>
