<?php
require_once 'AndroidDigiUploadDataObj.php';
$ccCode = '';
$fromdate = "";
$todate = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $fromdate = isset($_GET['fromdate']) ? stripslashes($_GET['fromdate']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $todate = isset($_GET['todate']) ? stripslashes($_GET['todate']) : "";
}
$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->getWarningVPBankFromTo($ccCode, $fromdate, $todate);

if (count($results) > 0) {
    $json = array("status" => "1", "content" => $results);
} else {
    $json = array("status" => "0", "content" => "no data found");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
