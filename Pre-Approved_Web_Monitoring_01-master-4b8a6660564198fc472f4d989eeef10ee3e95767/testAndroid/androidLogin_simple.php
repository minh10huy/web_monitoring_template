<?php

require_once 'AndroidDigiUploadDataObj.php';
$username = '';
$password = '';
$device_model = '';
$security_key = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $username = isset($_GET['username']) ? stripslashes($_GET['username']) : "";
    $password = isset($_GET['password']) ? stripslashes($_GET['password']) : "";
    $device_model = isset($_GET['model']) ? stripslashes($_GET['model']) : "";
    $security_key = isset($_GET['security_key']) ? stripslashes($_GET['security_key']) : "";
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->checkUserLogin($username, $password, $security_key);

if (count($results) > 0 && $results["cc_password"] === $password) {//&& $results["device_imei"] === $device_imei
        $json = array("status" => "1", "fullname" => $results["cc_name"], "channel" => $results["channel"], "province" => $results["province"]);
} else {
    $json = array("status" => "0", "msg" => "Tài khoản hoặc mật khẩu không đúng");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
