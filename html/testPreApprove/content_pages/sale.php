<?php

header("Content-Type: text/html;charset=UTF-8");
session_start();
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/..'),
    get_include_path()
)));

require_once '../lib/define/Conf.php';
require_once '../lib/db/PostgreSQLClass.php';
require_once '../lib/dto/GetDataReportFunctionName.php';
set_time_limit(1000000);

$columns = array(
    array('db' => 'ID', 'dt' => 0),
    array('db' => 'Customer Name', 'dt' => 1),
    array('db' => 'Input Type', 'dt' => 2),
    array('db' => 'Customer ID', 'dt' => 3),
    array('db' => 'IDF1', 'dt' => 4),
    array('db' => 'DSA Code', 'dt' => 5),
    array('db' => 'TSA Code', 'dt' => 6),    
    array('db' => 'CC Code', 'dt' => 7),
    array('db' => 'NTB Status', 'dt' => 8),
    array('db' => 'NTB Reason', 'dt' => 9),
    array('db' => 'Reason Bad', 'dt' => 10),
    array('db' => 'zip_id', 'dt' => 11)
);

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

//if ($_REQUEST !== NULL) {
//    $splitDate = explode("-", $_REQUEST['date']);
//    $fromDate = trim($splitDate[0]);
//    $toDate = trim($splitDate[1]);
//    $splitFromDate = explode("/", $fromDate);
//    $splitToDate = explode("/", $toDate);
//    $ccCode = $_SESSION['monitoring_username'];
//    $from = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0];
//    $to = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0];
//    $results = $vpBank->getSaleData($ccCode, $from, $to);
//}

require( '../ssp.class.pg.php' );
$request = $_REQUEST;
echo json_encode(
        SSP::simple2($con, 'CC104247', $request, $columns, '2016-07-20', '2016-07-21', 1)
);
die;




//require_once '../lib/dao/VPBankDAO.php';
//$vpBank = new VPBankDAO();
//
////$splitDate = explode("-", $_POST['date']);
////$fromDate = trim($splitDate[0]);
////$toDate = trim($splitDate[1]);
////$splitFromDate = explode("/", $fromDate);
////$splitToDate = explode("/", $toDate);
////$ccCode = $_SESSION['monitoring_username'];
////$from = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0];
////$to = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0];
////$results = $vpBank->getSaleData($ccCode, $from, $to);
//$results = $vpBank->getSaleData('CC104247', '2016-07-20', '2016-07-21');
//echo json_encode($results);
//die;
//?>