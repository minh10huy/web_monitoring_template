<?php

require_once 'DigiUploadDataObj.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ccCode = "";
$date = "";
$type = "";
if (isset($_GET['ccCode'])) {
    $ccCode = $_GET['ccCode'];
}
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

$dataObj = new DigiUploadDataObj();
$results = $dataObj->uploadPerDay($ccCode, $date, $type);
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

