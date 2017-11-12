<?php

require_once 'AndroidDigiUploadDataObj.php';
$username = '';
$password = '';
$device_model = '';
$device_imei = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $username = isset($_GET['username']) ? stripslashes($_GET['username']) : "";
    $password = isset($_GET['password']) ? stripslashes($_GET['password']) : "";
    $device_model = isset($_GET['model']) ? stripslashes($_GET['model']) : "";
    $device_imei = isset($_GET['imei']) ? stripslashes($_GET['imei']) : "";
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->checkUserLogin($username, $password);
//$results2 = $dataObj->checkRegisterDevice($device_model, $device_imei);

//$dataObj->insertUploadInfo($username, "file_name.zip", "HOSOMOI", "10.10.10.13");
//print_r($results["cc_password"]);die;
//md5($str);
//if (count($results) > 0 && $results["cc_password"] === md5($password)){//&& $results["device_imei"] === $device_imei) {
if (count($results) > 0 && $results["cc_password"] === $password) {//&& $results["device_imei"] === $device_imei
   // if (count($results2) > 0)
        $json = array("status" => "1", "fullname" => $results["cc_name"], "channel" => $results["channel"], "province" => $results["province"]);
    //else
    //    $json = array("status" => "-1", "msg" => "Wrong username or password");
} else {
    $json = array("status" => "0", "msg" => "Wrong username or password");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
