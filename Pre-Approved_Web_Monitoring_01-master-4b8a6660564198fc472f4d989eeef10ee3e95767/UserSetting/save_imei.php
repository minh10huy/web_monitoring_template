<?php
session_start();

require_once '../config.php';
// require (ROOT_PATH  . 'lib\\define\\Conf.php');
// require(ROOT_PATH  . 'lib\\dao\\LookupChannelDataDAO.php');
// require(ROOT_PATH  . 'lib\\db\\PostgreSQLClass.php');

//
require (ROOT_PATH  . 'lib/define/Conf.php');
require(ROOT_PATH  . 'lib/dao/LookupChannelDataDAO.php');
require(ROOT_PATH  . 'lib/db/PostgreSQLClass.php');

$device_model = pg_escape_string($_REQUEST['device_model']);
$device_imei = pg_escape_string($_REQUEST['device_imei']);
$notes = pg_escape_string($_REQUEST['notes']);

$lookupChannel = new LookupChannelDataDAO();

// Check duplicate cc_code
//if ($lookupChannel->checkDuplicateIMEI($device_imei)) {
//    echo json_encode(array('errorMsg' => 'There is already this existing imei number !' ));
//    die();
//}

$result = $lookupChannel->insertIMEI($device_model, $device_imei, $notes);
if ($result){
	echo json_encode(array('success' => 1
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>