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

$cc_code = pg_escape_string($_REQUEST['cc_code']);
$channel = pg_escape_string($_REQUEST['channel']);
$province= pg_escape_string($_REQUEST['province']);
$pos_code = pg_escape_string($_REQUEST['pos_code']);
$pos_name = pg_escape_string($_REQUEST['pos_name']);
$cc_role = $_REQUEST['cc_role'];
$cc_name = pg_escape_string($_REQUEST['cc_name']);
if ($_SESSION['monitoring_userrole'] == "teamleader")
    $parent_id = $_SESSION['userid'];
else 
    $parent_id = $_REQUEST['parent_channel'];
$mobile = isset($_REQUEST['is_android']) ? 1 : 0;
$lookupChannel = new LookupChannelDataDAO();

// Check duplicate cc_code
if ($lookupChannel->checkDuplicateCCCode($cc_code)) {
    echo json_encode(array('errorMsg' => 'There is alreay this existing cc code !' ));
    die();
}

$result = $lookupChannel->insertChannels($cc_code, $channel, $province, $pos_code, $pos_name, $cc_role, $cc_name, $parent_id, $mobile, $_SESSION['monitoring_username']);
if ($result){
	echo json_encode(array('success' => 1
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>