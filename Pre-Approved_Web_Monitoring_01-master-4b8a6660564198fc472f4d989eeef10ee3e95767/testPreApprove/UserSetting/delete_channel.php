<?php
require_once '../config.php';
// require (ROOT_PATH  . 'lib\\define\\Conf.php');
// require(ROOT_PATH  . 'lib\\dao\\LookupChannelDataDAO.php');
// require(ROOT_PATH  . 'lib\\db\\PostgreSQLClass.php');


require (ROOT_PATH  . 'lib/define/Conf.php');
require(ROOT_PATH  . 'lib/dao/LookupChannelDataDAO.php');
require(ROOT_PATH  . 'lib/db/PostgreSQLClass.php');
$id = intval($_REQUEST['id']);


$lookupChannel = new LookupChannelDataDAO();

$result = $lookupChannel->deleteChannels($id);
if ($result){
	echo json_encode(array('success' => 1
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>