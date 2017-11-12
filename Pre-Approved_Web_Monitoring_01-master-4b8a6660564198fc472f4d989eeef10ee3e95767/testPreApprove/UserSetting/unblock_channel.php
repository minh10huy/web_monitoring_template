<?php
session_start();

require_once '../config.php';
// require (ROOT_PATH  . 'lib\\define\\Conf.php');
// require(ROOT_PATH  . 'lib\\dao\\LookupChannelDataDAO.php');
// require(ROOT_PATH  . 'lib\\db\\PostgreSQLClass.php');


require (ROOT_PATH  . 'lib/define/Conf.php');
require(ROOT_PATH  . 'lib/dao/LookupChannelDataDAO.php');
require(ROOT_PATH  . 'lib/db/PostgreSQLClass.php');

$username = $_REQUEST['username'];


$lookupChannel = new LookupChannelDataDAO();

$result = $lookupChannel->unblockChannels($username);
if ($result){
	echo json_encode(array('success' => 1
	));
} else {
	echo json_encode(array('errorMsg'=>'This user is not currently blocked'));
}
?>