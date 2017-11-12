<?php
//$today = "2015-07-13";
//$time = date('H:i:s', time());
require_once 'AndroidDigiUploadDataObj.php';
$ccCode = "";
$cusName = '';
$cusID = '';
$searchtype = 0;
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $cusName = isset($_GET['cusName']) ? stripslashes($_GET['cusName']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $cusID = isset($_GET['cusID']) ? stripslashes($_GET['cusID']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}
if ($cusName != '') {
    $cusInfo = $cusName;
    $searchtype = 0;
} else if ($cusID != '') {
    $cusInfo = $cusID;
    $searchtype = 1;
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->searchAppStatusByCusInfo($ccCode, $cusInfo, $searchtype);

if (count($results) > 0) {
    $json = array("status" => "1", "content" => $results);
} else {
    $json = array("status" => "0", "content" => "no data found");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
