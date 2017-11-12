<?php

session_start();

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';
require_once 'lib/dto/GetDataReportFunctionName.php';
// DB table to use

set_time_limit(1000000);
$type = $_REQUEST['type'];
$getDataReportFunctionName = new GetDataReportFunctionName();


$function = "";

switch ($type) {
    case "1" :
        $columns = array(
            array('db' => '#', 'dt' => 0),
            array('db' => 'User', 'dt' => 1),
            array('db' => 'CC Name', 'dt' => 2),
            array('db' => 'Channel', 'dt' => 3),
            array('db' => 'Province', 'dt' => 4),
            array('db' => 'From', 'dt' => 5),
            array('db' => 'To', 'dt' => 6),
            array('db' => 'Finished', 'dt' => 7),
            array('db' => 'Canceled', 'dt' => 8),
            array('db' => 'Duplication', 'dt' => 9),
            array('db' => 'Pending', 'dt' => 10)
            );
        $function = $getDataReportFunctionName->sp_get_data_report_general;
        break;
    case "2" :
        $columns = array(
            array('db' => '#', 'dt' => 0),
            array('db' => 'Date', 'dt' => 1),
            array('db' => 'User', 'dt' => 2),
            array('db' => 'CC Name', 'dt' => 3),
            array('db' => 'Channel', 'dt' => 4),
            array('db' => 'Province', 'dt' => 5),
            array('db' => 'Hard', 'dt' => 6),
            array('db' => 'Soft', 'dt' => 7),
            array('db' => 'Cancelled', 'dt' => 8),
            array('db' => 'Pending', 'dt' => 9)
            );
         $function = $getDataReportFunctionName->sp_get_data_report_general_form3;
        break;
    case "3" :
        $columns = array(
            array('db' => 'Day', 'dt' => 0),
            array('db' => 'Done - Meeting', 'dt' => 1),
            array('db' => 'Done - Pending', 'dt' => 2),
            array('db' => 'Duplicate', 'dt' => 3),
            array('db' => 'Entered', 'dt' => 4),
            array('db' => 'Meeting', 'dt' => 5),
            array('db' => 'Pending', 'dt' => 6),
            array('db' => 'Pending - Updated', 'dt' => 7),
            array('db' => 'QDE - Cancel', 'dt' => 8),
            array('db' => 'QDE - Done', 'dt' => 9),
            array('db' => 'QDE - Others', 'dt' => 10),
            array('db' => 'QDE - Updated', 'dt' => 11));
        $function = $getDataReportFunctionName->sp_get_data_report_general_preapprove;
        break;
    case "4" :
        $columns = array(
            array('db' => 'Date', 'dt' => 0),
            array('db' => 'User', 'dt' => 1),
            array('db' => 'CC Name', 'dt' => 2),
            array('db' => 'Channel', 'dt' => 3),
            array('db' => 'Province', 'dt' => 4),
            array('db' => 'Hard', 'dt' => 5),
            array('db' => 'Soft', 'dt' => 6),
            array('db' => 'Cancelled', 'dt' => 7),
            array('db' => 'Pending', 'dt' => 8)
            );
        $function = $getDataReportFunctionName->sp_get_data_report_general_mobile_qde;
        break;
    case "5" :
        $columns = array(
            array('db' => 'User', 'dt' => 0),
            array('db' => 'CC Name', 'dt' => 1),
            array('db' => 'Channel', 'dt' => 2),
            array('db' => 'Province', 'dt' => 3),
            array('db' => 'From', 'dt' => 4),
            array('db' => 'To', 'dt' => 5),
            array('db' => 'Finished', 'dt' => 6),
            array('db' => 'Canceled', 'dt' => 7),
            array('db' => 'Duplication', 'dt' => 8),
            array('db' => 'Pending', 'dt' => 9)
            );
        $function = $getDataReportFunctionName->sp_get_data_report_general_mobile_newapp;
        break; 
    case "6" :
        $columns = array(
            array('db' => 'Day', 'dt' => 0),
            array('db' => 'Done - Meeting', 'dt' => 1),
            array('db' => 'Done - Pending', 'dt' => 2),
            array('db' => 'Duplicate', 'dt' => 3),
            array('db' => 'Entered', 'dt' => 4),
            array('db' => 'Meeting', 'dt' => 5),
            array('db' => 'Pending', 'dt' => 6),
            array('db' => 'Pending - Updated', 'dt' => 7),
            array('db' => 'QDE - Cancel', 'dt' => 8),
            array('db' => 'QDE - Done', 'dt' => 9),
            array('db' => 'QDE - Others', 'dt' => 10),
            array('db' => 'QDE - Updated', 'dt' => 11));
        $function = $getDataReportFunctionName->sp_get_data_report_general_preapprove_crc;
        break;    
}

$pgSQL = new PostgreSQLClass();
$con = $pgSQL->getConDPO_DIGISOFT();
if (!$con) {
    echo json_encode(array(
			"draw"            => intval( $_REQUEST['draw'] ),
			"recordsTotal"    => null,
			"recordsFiltered" => null,
			"data"            => array())
		);
    die();
}

// SQL server connection information
// $userInfo = $this->getUserInfo($user);
//        if (count($userInfo) == 0) {
//            return $resultDataReport;
//        }
if ($_REQUEST['FromDate'] != null && $_REQUEST['ToDate'] != null) {

    $splitFromDate = explode("/", $_REQUEST['FromDate']);
    $splitToDate = explode("/", $_REQUEST['ToDate']);

//    $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0] . " " . "00:00:00";
//    $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0] . " " . "23:59:59";
    
    $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0] . " " . "00:00:00";
    $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0] . " " . "23:59:59";    
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.pg.php' );
$request = $_REQUEST;

echo json_encode(
        SSP::simple($con, $_SESSION['monitoring_username'], $function, $request, $columns, $fromDate, $toDate, 1)
);