<?php
session_start();

require_once '../config.php';
// require (ROOT_PATH  . 'lib\\define\\Conf.php');
// require(ROOT_PATH  . 'lib\\dao\\LookupChannelDataDAO.php');
// require(ROOT_PATH  . 'lib\\db\\PostgreSQLClass.php');


require (ROOT_PATH  . 'lib/define/Conf.php');
require(ROOT_PATH  . 'lib/dao/LookupChannelDataDAO.php');
require(ROOT_PATH  . 'lib/db/PostgreSQLClass.php');

        $conn = PostgreSQLClass::getConn();
        

        
        // declare my query and execute
        $rs = pg_query($conn, "SELECT id, cc_name || ' (' || cc_code || ')' as parent_channel FROM db_16001_0001_bak_20160525.lookup_channel WHERE cc_role = 'teamleader' OR cc_role = 'supervisor' ORDER BY 2");
      
        // process results
        $items = array();
        
        $count = 0;
        while ($row = pg_fetch_object($rs)) {
            $items[$count]['id'] =  $row->id;
            $items[$count]['parent_channel'] =  $row->parent_channel;
            $count++;
        }
       
//        $result["rows"] = $items;
        echo json_encode($items);

?>
