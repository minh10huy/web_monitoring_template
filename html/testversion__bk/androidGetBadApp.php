<?php
//$today = "2015-07-13";
//$time = date('H:i:s', time());
require_once 'AndroidDigiUploadDataObj.php';
$ccCode = "";
$today = "";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}
//if (isset($_GET['ccCode'])) {
//    $ccCode = $_GET['ccCode'];
//}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $today = isset($_GET['date']) ? stripslashes($_GET['date']) : "";
}
if($today === ""){
    $today = date("Y-m-d");
}
$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->getBadApp($ccCode, $today);
//$results = $dataObj->checkExistData($ccCode);

//echo $results[0]['cc_code'];die;
//echo count($results);die;

if (count($results) > 0) {
    $json = array("status" => "1", "content" => $results);
} else {
    $json = array("status" => "0", "content" => "no data found");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
