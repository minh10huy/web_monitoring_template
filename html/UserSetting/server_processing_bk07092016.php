<?php
session_start();

require_once '../config.php';
// require (ROOT_PATH  . 'lib\\define\\Conf.php');
// require(ROOT_PATH  . 'lib\\dao\\LookupChannelDataDAO.php');
// require(ROOT_PATH  . 'lib\\db\\PostgreSQLClass.php');

require (ROOT_PATH  . 'lib/define/Conf.php');
require(ROOT_PATH  . 'lib/dao/LookupChannelDataDAO.php');
require(ROOT_PATH  . 'lib/db/PostgreSQLClass.php');

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
$filter = isset($_POST['filter_value']) ? pg_escape_string($_POST['filter_value']) : '';
$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'cc_code';
$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
$user_id = strval($_POST['id']);

$offset = ($page-1)*$rows;
$lookupChannel = new LookupChannelDataDAO;

if ($_SESSION['monitoring_userrole'] == "admin" || $_SESSION['monitoring_userrole'] == "supervisor" || $_SESSION['monitoring_userrole'] == "subadmin" || $_SESSION['monitoring_userrole'] == "teamleader")
    $result = $lookupChannel->getChannels($rows, $offset, $filter, $sort, $order);
else     
    $result = $lookupChannel->getChannels($rows, $offset, $filter, $sort, $order, $user_id);


echo json_encode(
	$result
);


?>
