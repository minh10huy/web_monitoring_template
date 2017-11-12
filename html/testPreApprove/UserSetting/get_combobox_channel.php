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
        $rs = pg_query($conn, "SELECT id, cc_name || '-' || channel as parent_channel FROM db_16001_0001_bak_20160525.lookup_channel WHERE id = (SELECT parent_id FROM db_16001_0001_bak_20160525.lookup_channel WHERE id = ". intval($_POST['id']) ." )");
      
        // process results
        $items = array();
        
        $row = pg_fetch_object($rs);
        $items['id'] =  $row->id;
        $items['parent_channel'] =  $row->parent_channel;

        echo json_encode($items);

?>
