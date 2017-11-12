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



        $function = "sp_get_data_report_tat";

        $columns = array(
            array('db' => 'No.', 'dt' => 0),
            array('db' => 'Content', 'dt' => 1),
            array('db' => 'PL Normal', 'dt' => 2),
            array('db' => 'PL Mobile', 'dt' => 3),
            array('db' => 'Pre-Approve', 'dt' => 4),
            array('db' => 'QDE Normal', 'dt' => 5),
            array('db' => 'QDE Mobile', 'dt' => 6)
            );

   


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
if ($_REQUEST['date'] != null) {
    $splitDate = explode("-", $_REQUEST['date']);
    $fromDate = trim($splitDate[0]);
    $toDate = trim($splitDate[1]);

    $splitFromDate = explode("/", $fromDate);
    $splitToDate = explode("/", $toDate);

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
        SSP::simple($con, null, $function, $request, $columns, $fromDate, $toDate, 1)
);