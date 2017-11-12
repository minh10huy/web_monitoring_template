<?php
header('Content-type: application/json');
$json = array("status" => "1", "idf1" => '5555555', "customer_name" => 'Xuan Vi', "customer_id" => '999999999');
echo json_encode($json);
die;
require_once 'AndroidDigiUploadDataObj.php';
$idf1 = '';
$ccCode = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $idf1 = isset($_GET['idf1']) ? stripslashes($_GET['idf1']) : "";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ccCode = isset($_GET['ccCode']) ? stripslashes($_GET['ccCode']) : "";
}

//echo $idf1;die;
$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->checkIDF1($idf1.'-'.$ccCode);
$resultsReturn = array();
for ($i = 0; $i < count($results); $i++) {
    foreach ($results[$i] as $key => $value) {
        if ($key === 'id_f1' || $key === 'folder_customer_name' || $key === 'folder_customer_cmnd')
            $resultsReturn[$key] = $value;
    }
}

if (count($resultsReturn) > 0) {
    $json = array("status" => "1", "idf1" => $resultsReturn["id_f1"], "customer_name" => $resultsReturn["folder_customer_name"], "customer_id" => $resultsReturn["folder_customer_cmnd"]);
} else {
    $json = array("status" => "0", "msg" => "invalid idf1");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
