<?php
//$today = "2015-07-13";
//$time = date('H:i:s', time());
require_once 'AndroidDigiUploadDataObj.php';
$ccCode = "";
$fromdate = "";
$todate = "";
$typeview = "";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $fromdate = isset($_GET['fromdate']) ? stripslashes($_GET['fromdate']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $todate = isset($_GET['todate']) ? stripslashes($_GET['todate']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $typeview = isset($_GET['typeview']) ? stripslashes($_GET['typeview']) : "";
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->getAppStatusFromTo($ccCode, $fromdate, $todate, $typeview);

if (count($results) > 0) {
    $json = array("status" => "1", "content" => $results);
} else {
    $json = array("status" => "0", "content" => "no data found");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
