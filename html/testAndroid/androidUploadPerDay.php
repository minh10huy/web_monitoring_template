<?php

require_once 'AndroidDigiUploadDataObj.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ccCode = "";
$fromdate = "";
$todate = "";
$type = "";
if (isset($_GET['ccCode'])) {
    $ccCode = $_GET['ccCode'];
}
if (isset($_GET['fromdate'])) {
    $fromdate = $_GET['fromdate'];
}
if (isset($_GET['todate'])) {
    $todate = $_GET['todate'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

$dataObj = new AndroidDigiUploadDataObj();
$results = $dataObj->uploadPerDay($ccCode, $fromdate, $todate, $type);
$res = array();
for ($index = 0; $index < count($results); $index++) {
    $res[$index] = $results[$index][0];
}


//if (count($results) > 0 ) {
//    
//    $json = array("count" => $results[0]);
//} else {
//    $json = array("count" => "0");
//}

/* Output header */
header('Content-type: application/json');
echo json_encode($res);

