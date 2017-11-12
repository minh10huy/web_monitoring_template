<?php

$today = date("Y-m-d");
//$today = "2015-07-13";
//$time = date('H:i:s', time());

require_once 'AndroidDigiUploadDataObj.php';
$cusName = '';
$id_f1 = '';
$searchtype = 0;
$ccCode = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $cusName = isset($_GET['cusName']) ? stripslashes($_GET['cusName']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id_f1 = isset($_GET['id_f1']) ? stripslashes($_GET['id_f1']) : "";
}
if ($cusName != '') {
    $cusInfo = $cusName;
    $searchtype = 0;
} else if ($id_f1 != '') {
    $cusInfo = $id_f1;
    $searchtype = 1;
}
$dataObj = new AndroidDigiUploadDataObj();
if ($cusInfo != null && $cusInfo != '')
    $results = $dataObj->searchWarningVPBankByCustomerInfo($cusInfo, $searchtype, $ccCode);

if (count($results) > 0) {
    $json = array("status" => "1", "content" => $results);
} else {
    $json = array("status" => "0", "content" => "no data found");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
