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
require_once ('lib/dto/GetDataReportFunctionName.php');
// DB table to use

set_time_limit(1000000);
$type = $_REQUEST['type'];
$getDataReportFunctionName = new GetDataReportFunctionName();
$function = "";
switch ($type) {
    case "1" :
        $columns = array(
            array('db' => '#', 'dt' => 0),
            array('db' => 'Upload Date', 'dt' => 1),
            array('db' => 'Upload Time', 'dt' => 2),
            array('db' => 'Download Date', 'dt' => 3),
            array('db' => 'Download Time', 'dt' => 4),
            array('db' => 'Folder', 'dt' => 5),
            array('db' => 'CC Code', 'dt' => 6),
            array('db' => 'CC Name', 'dt' => 7),
            array('db' => 'Province', 'dt' => 8),
            array('db' => 'Customer Name', 'dt' => 9),
            array('db' => 'ID number', 'dt' => 10),
            array('db' => 'Channel', 'dt' => 11),
            array('db' => 'Cancel', 'dt' => 12),
            array('db' => 'Reason', 'dt' => 13),
            array('db' => 'Note', 'dt' => 14),
            array('db' => 'Size', 'dt' => 15),
            array('db' => 'Filename', 'dt' => 16),
            array('db' => 'Check', 'dt' => 17),
            array('db' => 'Classify user SG', 'dt' => 18),
            array('db' => 'Classify Speed', 'dt' => 19),
            array('db' => 'ID F1', 'dt' => 20),
            array('db' => 'User F1', 'dt' => 21),
            array('db' => 'Status F1', 'dt' => 22),
            array('db' => 'F1 Reason', 'dt' => 23),
            array('db' => 'DE user SG', 'dt' => 24),
            array('db' => 'DE Date', 'dt' => 25),
            array('db' => 'DE Time', 'dt' => 26),
            array('db' => 'Speed DE', 'dt' => 27),
            array('db' => 'Turn Around Time (h)', 'dt' => 28),
            array('db' => 'Duplication', 'dt' => 29),
            array('db' => 'Duplication Date', 'dt' => 30),
            array('db' => 'CC Code Dup', 'dt' => 31)
        );
        $function = $getDataReportFunctionName->sp_get_data_report_details;
        break;
    case "2" :
        $columns = array(
            array('db' => '#', 'dt' => 0),
            array('db' => 'Download Date', 'dt' => 1),
            array('db' => 'Download Time', 'dt' => 2),
            array('db' => 'Folder', 'dt' => 3),
            array('db' => 'CC Code', 'dt' => 4),
            array('db' => 'CC Name', 'dt' => 5),
            array('db' => 'Province', 'dt' => 6),
            array('db' => 'Kind', 'dt' => 7),
            array('db' => 'Name', 'dt' => 8),
            array('db' => 'ID number', 'dt' => 9),
            array('db' => 'Channel', 'dt' => 10),
            array('db' => 'Cancel', 'dt' => 11),
            array('db' => 'Cancel Reason', 'dt' => 12),
            array('db' => 'ID F1', 'dt' => 13),
            array('db' => 'User F1', 'dt' => 14),
            array('db' => 'Reason', 'dt' => 15),
            array('db' => 'Notes', 'dt' => 16),
            array('db' => 'Date', 'dt' => 17),
            array('db' => 'Time', 'dt' => 18),
            array('db' => 'Speed', 'dt' => 19),
            array('db' => 'Turn Around Time (h)', 'dt' => 20),
            array('db' => 'From VPBank', 'dt' => 21),
            array('db' => 'From SaigonBPO', 'dt' => 22)
        );
        $function = $getDataReportFunctionName->sp_get_data_report_details_form3;
        break;
    case "3" :
        $columns = array(
            array('db' => '#', 'dt' => 0),
            
            array('db' => 'Download Time', 'dt' => 1),
            
            array('db' => 'ID F1', 'dt' => 2),
            array('db' => 'Status F1', 'dt' => 3),
            array('db' => 'QDE Reason of Sale', 'dt' => 4),
            array('db' => 'Status SaigonBPO', 'dt' => 5),
            array('db' => 'Reason NOT OK', 'dt' => 6),
            array('db' => 'Opportunity Name', 'dt' => 7),
            array('db' => 'No. Agreement ID', 'dt' => 8),
            array('db' => 'TSA Code F1', 'dt' => 9),
            array('db' => 'TSA Name', 'dt' => 10),
            array('db' => 'TSA Phone Number', 'dt' => 11),
            array('db' => 'Product Name 1', 'dt' => 12),
            array('db' => 'Product Code 1', 'dt' => 13),
            array('db' => 'Loan Amount Request', 'dt' => 14),
            array('db' => 'Loan Term Request', 'dt' => 15),
            array('db' => 'Insurance', 'dt' => 16),
            array('db' => 'Insurance Plus', 'dt' => 17),
            array('db' => 'Insurance Name', 'dt' => 18),
            array('db' => 'Date of Closure', 'dt' => 19),
            array('db' => 'Disb Channel', 'dt' => 20),
            array('db' => 'Branch Code', 'dt' => 21),
            
            array('db' => 'Meeting City', 'dt' => 22),
            
            array('db' => 'Description', 'dt' => 23),
            array('db' => 'Referee 1', 'dt' => 24),
            array('db' => 'Referee 2', 'dt' => 25),
            array('db' => 'Spouse Name', 'dt' => 26),
            array('db' => 'CC Code', 'dt' => 27),
            array('db' => 'CC Name', 'dt' => 28),
            array('db' => 'DSA Code', 'dt' => 29),
            array('db' => 'DSA Name', 'dt' => 30),
            array('db' => 'New ID Card Number', 'dt' => 31),
            array('db' => 'Date of Issue', 'dt' => 32),
            array('db' => 'Place of Issue', 'dt' => 33),
            array('db' => 'New Phone', 'dt' => 34),
            array('db' => 'Address', 'dt' => 35),
            array('db' => 'Actual Address', 'dt' => 36),
            array('db' => 'Monthly Income', 'dt' => 37),
            array('db' => 'Monthly Costs', 'dt' => 38),
            array('db' => 'Monthly Income Family', 'dt' => 39),
            array('db' => 'Monthly Costs Family', 'dt' => 40),
            array('db' => 'Number of Modified Fields', 'dt' => 41),
            array('db' => 'Modified Fields', 'dt' => 42),
            
            array('db' => 'management_id', 'dt' => 43)
        );
        $function = $getDataReportFunctionName->sp_get_data_report_details_preapprove;
        break;
    case "4" :
        $columns = array(
            array('db' => 'Download Date', 'dt' => 0),
            array('db' => 'Download Time', 'dt' => 1),
            array('db' => 'Folder', 'dt' => 2),
            array('db' => 'CC Code', 'dt' => 3),
            array('db' => 'CC Name', 'dt' => 4),
            array('db' => 'Province', 'dt' => 5),
            array('db' => 'Kind', 'dt' => 6),
            array('db' => 'Name', 'dt' => 7),
            array('db' => 'ID number', 'dt' => 8),
            array('db' => 'Channel', 'dt' => 9),
            array('db' => 'Cancel', 'dt' => 10),
            array('db' => 'Cancel Reason', 'dt' => 11),
            array('db' => 'ID F1', 'dt' => 12),
            array('db' => 'User F1', 'dt' => 13),
            array('db' => 'Reason', 'dt' => 14),
            array('db' => 'Notes', 'dt' => 15),
            array('db' => 'Date', 'dt' => 16),
            array('db' => 'Time', 'dt' => 17),
            array('db' => 'Speed', 'dt' => 18),
            array('db' => 'Turn Around Time (h)', 'dt' => 19)
        );
        $function = $getDataReportFunctionName->sp_get_data_report_details_mobile_qde;
        break;
    case "5" :
        $columns = array(
            array('db' => '#', 'dt' => 0),
            array('db' => 'Upload Date', 'dt' => 1),
            array('db' => 'Upload Time', 'dt' => 2),
            array('db' => 'Download Date', 'dt' => 3),
            array('db' => 'Download Time', 'dt' => 4),
            array('db' => 'Folder', 'dt' => 5),
            array('db' => 'CC Code', 'dt' => 6),
            array('db' => 'CC Name', 'dt' => 7),
            array('db' => 'Province', 'dt' => 8),
            array('db' => 'Customer Name', 'dt' => 9),
            array('db' => 'ID number', 'dt' => 10),
            array('db' => 'Channel', 'dt' => 11),
            array('db' => 'Cancel', 'dt' => 12),
            array('db' => 'Reason', 'dt' => 13),
            array('db' => 'Note', 'dt' => 14),
            array('db' => 'Size', 'dt' => 15),
            array('db' => 'Filename', 'dt' => 16),
            array('db' => 'Check', 'dt' => 17),
            array('db' => 'Classify user SG', 'dt' => 18),
            array('db' => 'Classify Speed', 'dt' => 19),
            array('db' => 'ID F1', 'dt' => 20),
            array('db' => 'User F1', 'dt' => 21),
            array('db' => 'DE user SG', 'dt' => 22),
            array('db' => 'DE Date', 'dt' => 23),
            array('db' => 'DE Time', 'dt' => 24),
            array('db' => 'Speed DE', 'dt' => 25),
            array('db' => 'Turn Around Time (h)', 'dt' => 26),
            array('db' => 'Duplication', 'dt' => 27),
            array('db' => 'Duplication Date', 'dt' => 28),
            array('db' => 'CC Code Dup', 'dt' => 29),
            array('db' => 'management_id', 'dt' => 30)
        );
        $function = $getDataReportFunctionName->sp_get_data_report_details_mobile_newapp;
        break;
    case "6" :
        $columns = array(
            array('db' => 'Edit', 'dt' => 0),
            array('db' => '#', 'dt' => 1),
            array('db' => 'management_id', 'dt' => 2),
            array('db' => 'TSA Code F1', 'dt' => 3),
            array('db' => 'TSA Name', 'dt' => 4),
            array('db' => 'TSA Phone Number', 'dt' => 5),
            array('db' => 'Product Name 1', 'dt' => 6),
            array('db' => 'Product Code 1', 'dt' => 7),
            array('db' => 'Loan Amount Request', 'dt' => 8),
            array('db' => 'Loan Term Request', 'dt' => 9),
            array('db' => 'Insurance', 'dt' => 10),
            array('db' => 'Date of Closure', 'dt' => 11),
            array('db' => 'Disb Channel', 'dt' => 12),
            array('db' => 'Branch Code', 'dt' => 13),
            array('db' => 'Description', 'dt' => 14),
            array('db' => 'ID F1', 'dt' => 15),
            array('db' => 'Status F1', 'dt' => 16),
            array('db' => 'QDE Reason of Sale', 'dt' => 17),
            array('db' => 'Status SaigonBPO', 'dt' => 18),
            array('db' => 'Reason NOT OK', 'dt' => 19),
            array('db' => 'Referee 1', 'dt' => 20),
            array('db' => 'Referee 2', 'dt' => 21),
            array('db' => 'Spouse Name', 'dt' => 22),
            array('db' => 'CC Code', 'dt' => 23),
            array('db' => 'CC Name', 'dt' => 24),
            array('db' => 'DSA Code', 'dt' => 25),
            array('db' => 'DSA Name', 'dt' => 26),
            array('db' => 'Opportunity Name', 'dt' => 27),
            array('db' => 'No. Agreement ID', 'dt' => 28),
            array('db' => 'New ID Card Number', 'dt' => 29),
            array('db' => 'Date of Issue', 'dt' => 30),
            array('db' => 'Place of Issue', 'dt' => 31),
            array('db' => 'New Phone', 'dt' => 32),
            array('db' => 'Address', 'dt' => 33),
            array('db' => 'Actual Address', 'dt' => 34),
            array('db' => 'Monthly Income', 'dt' => 35),
            array('db' => 'Monthly Costs', 'dt' => 36),
            array('db' => 'Monthly Income Family', 'dt' => 37),
            array('db' => 'Monthly Costs Family', 'dt' => 38),
            array('db' => 'Product Name', 'dt' => 39),
            array('db' => 'Product Code', 'dt' => 40),
            array('db' => 'Offered Credit Limit', 'dt' => 41),
            array('db' => 'Embossing Name', 'dt' => 42),
            array('db' => 'Mailing Address', 'dt' => 43),
            array('db' => 'Answer for Security Question', 'dt' => 44),
            array('db' => 'Number of Modified Fields', 'dt' => 45),
            array('db' => 'Modified Fields', 'dt' => 46),
            array('db' => 'Download Time', 'dt' => 47),
            array('db' => 'is_editable', 'dt' => 48)
        );
        $function = $getDataReportFunctionName->sp_get_data_report_details_preapprove_crc;
        break;
}



$pgSQL = new PostgreSQLClass();
$con = $pgSQL->getConDPO_DIGISOFT();
if (!$con) {
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
//echo json_encode($fromDate.$toDate.$type);die;
echo json_encode(
        SSP::simple($con, $_SESSION['monitoring_username'], $function, $request, $columns, $fromDate, $toDate, 1)
);
