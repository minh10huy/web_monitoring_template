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
require_once '../config.php';
require (ROOT_PATH . 'lib/define/Conf.php');
require(ROOT_PATH . 'lib/db/PostgreSQLClass.php');
require(ROOT_PATH . 'ssp.class.pg.php' );

// DB table to use

set_time_limit(1000000);
$request = $_REQUEST;
$pgSQL = new PostgreSQLClass();
$con = $pgSQL->getConDPO_DIGISOFT();
if (!$con) {
    echo json_encode(array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => null,
        "recordsFiltered" => null,
        "data" => array())
    );
    die();
}

$report_type = $_REQUEST['report_type'];
switch ($report_type) {
    case "1" : // TAT Report
        $columns = array(
            array('db' => 'No.', 'dt' => 0),
            array('db' => 'Content', 'dt' => 1),
            array('db' => 'PL Normal', 'dt' => 2),
            array('db' => 'PL Mobile', 'dt' => 3),
            array('db' => 'PL Pre-Approve', 'dt' => 4),
            array('db' => 'CRC Pre-Approve', 'dt' => 5),
            array('db' => 'QDE Normal', 'dt' => 6),
            array('db' => 'QDE Mobile', 'dt' => 7),
            array('db' => 'QDE PL Pre-Approve', 'dt' => 8),
            array('db' => 'QDE CRC Pre-Approve', 'dt' => 9)
        );
        if ($_REQUEST['date'] != null) {
            $splitDate = explode("-", $_REQUEST['date']);
            $fromDate = trim($splitDate[0]);
            $toDate = trim($splitDate[1]);

            $splitFromDate = explode("/", $fromDate);
            $splitToDate = explode("/", $toDate);

            $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0] . " " . "00:00:00";
            $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0] . " " . "23:59:59";
        }
        $function = "sp_get_data_report_tat_new";
        echo json_encode(
                SSP::simple($con, null, $function, $request, $columns, $fromDate, $toDate)
        );
        exit();
        break;
    case "2" : // Daily Amount (Each Product)
        
        $columns = array(
            array('db' => 'Type', 'dt' => 0),
            array('db' => 'Amount', 'dt' => 1)
        );
        $function = "sp_get_data_report_daily_total_download_new";
        break;
    case "3" : // Daily Amount (Monthly)
        $columns = array(
            array('db' => 'Type', 'dt' => 0)
        );
        foreach ($_REQUEST['days_month'] as $key => $value) {
           $columns[] =  array('db' => $value, 'dt' => $key+1);
        }
        $function = "sp_get_data_report_daily_total_download_in_month_new";
        break;
    case "4" : // Average TAT Report
        $columns = array(
            array('db' => 'Type', 'dt' => 0),
            array('db' => 'Average TAT', 'dt' => 1),
            array('db' => 'Standard TAT', 'dt' => 2)
        );
        $function = "sp_get_data_report_daily_average_tat";
        break;
    case "5" : // Daily Resource
        
        $function = "sp_get_data_report_tat_daily";
        break;
    case "6" : // Hourly Downloaded Amount
        $columns = array(
            array('db' => 'download_hour', 'dt' => 0),
            array('db' => 'PL_Normal', 'dt' => 1),
            array('db' => 'PL_Mobile', 'dt' => 2),
            array('db' => 'QDE_Normal', 'dt' => 3),
            array('db' => 'QDE_Mobile', 'dt' => 4),
            array('db' => 'QDE_PL_PreApprove', 'dt' => 5),
            array('db' => 'QDE_CRC_PreApprove', 'dt' => 6),
            array('db' => 'PL Pre-Approve', 'dt' => 7),
            array('db' => 'CRC Pre-Approve', 'dt' => 8));            
        $function = "sp_get_data_report_tat_hourly_total_download_new";
        break;
    case "7" : // Hourly User Amount
        $columns = array(
            array('db' => 'download_hour', 'dt' => 0),
            array('db' => 'PL', 'dt' => 1),
            array('db' => 'QDE', 'dt' => 2),
            array('db' => 'Pre-Approve', 'dt' => 3));
        $function = "sp_get_data_report_tat_hourly_total_download";
        break;
    case "8" : // Status
        $columns = array(
            array('db' => 'No.', 'dt' => 0),
            array('db' => 'Type', 'dt' => 1),
            array('db' => 'Status', 'dt' => 2),
            array('db' => '09:00', 'dt' => 3),
            array('db' => '10:00', 'dt' => 4),
            array('db' => '11:00', 'dt' => 5),
            array('db' => '12:00', 'dt' => 6),
            array('db' => '13:00', 'dt' => 7),
            array('db' => '14:00', 'dt' => 8),
            array('db' => '15:00', 'dt' => 9),
            array('db' => '16:00', 'dt' => 10),
            array('db' => '17:00', 'dt' => 11),
            array('db' => '18:00', 'dt' => 12),
            array('db' => '19:00', 'dt' => 13),
            array('db' => '20:00', 'dt' => 14),
            array('db' => '21:00', 'dt' => 15),
            array('db' => '22:00', 'dt' => 16),
            array('db' => 'Sum', 'dt' => 17)
        );
        $function = "sp_get_data_report_tat_daily_new";
        break;
    case "9" : // Hourly Over TAT
        $columns = array(
            array('db' => 'No.', 'dt' => 0),
            array('db' => 'Type', 'dt' => 1),
            array('db' => '>1h', 'dt' => 2),
            array('db' => '>2h', 'dt' => 3),
            array('db' => '>3h', 'dt' => 4),
            array('db' => '>4h', 'dt' => 5),
            array('db' => '>5h', 'dt' => 6)
        );
        $function = "sp_get_data_report_tat_hourly_over_tat";
        break;
}

echo json_encode(
        SSP::simple($con, null, $function, $request, $columns, $_REQUEST['date'])
);








// SQL server connection information
// $userInfo = $this->getUserInfo($user);
//        if (count($userInfo) == 0) {
//            return $resultDataReport;
//        }


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */



