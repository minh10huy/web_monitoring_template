<?php

require_once 'DigiUploadDataObj.php';
$username = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $username = isset($_GET['username']) ? stripslashes($_GET['username']) : "";
    $password = isset($_GET['password']) ? stripslashes($_GET['password']) : "";
}

$dataObj = new DigiUploadDataObj();
$results = $dataObj->checkUserLogin($username, $password);
//$dataObj->insertUploadInfo($username, "file_name.zip", "HOSOMOI", "10.10.10.13");
//print_r($results["cc_password"]);die;
//md5($str);

if (count($results) > 0 && $results["cc_password"] === md5($password)) {
    $json = array("status" => "1", "fullname" => $results["cc_name"], "channel" => $results["channel"], "province" => $results["province"]);
} else {
    $json = array("status" => "0", "msg" => "Wrong username or password");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
