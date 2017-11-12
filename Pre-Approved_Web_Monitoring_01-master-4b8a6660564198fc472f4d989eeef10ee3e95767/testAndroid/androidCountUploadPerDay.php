<?php
require_once 'AndroidDigiUploadDataObj.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ccCode = "";
$upload_date = "";
$type = "";
if (isset($_GET['ccCode'])) {
    $ccCode = $_GET['ccCode'];
}
if (isset($_GET['upload_date'])) {
    $upload_date = $_GET['upload_date'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->countUploadPerDay($ccCode, $upload_date, $type);

if (count($results) > 0 ) {    
    $json = array("count" => $results[0]);
} else {
    $json = array("count" => "0");
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
