<?php

$today = date("Y-m-d");
//$today = "2015-07-13";
//$time = date('H:i:s', time());

require_once 'AndroidDigiUploadDataObj.php';
$ccCode = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->getWarningVPBank($ccCode, $today);

if (count($results) > 0) {
    $json = array("status" => "1", "content" => $results);
} else {
    $json = array("status" => "0", "content" => "no data found");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
