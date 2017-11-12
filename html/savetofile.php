<?php

require_once 'DigiUploadDataObj.php';
$dataObj = new DigiUploadDataObj();
echo $_FILES['upFile']['name'] . '<br/>';

$ccCode = '';
$ccChannel = '';
$upType = '';
$ip = '';
//include_once('customdemo/confi.php');
$today = date("d_m_Y");
$newApp = 'HOSOMOI';
$QDE = 'HOSOBOSUNG';

if (!is_dir('uploads/' . $newApp)) {
    mkdir('uploads/' . $newApp);
}
if (!is_dir('uploads/' . $QDE)) {
    mkdir('uploads/' . $QDE);
}

if (isset($_POST['ccCode'])) {
    $ccCode = $_POST['ccCode'];
}
if (isset($_POST['ccChannel'])) {
    $ccChannel = $_POST['ccChannel'];
}
if (isset($_POST['upType'])) {
    $upType = $_POST['upType'];
}
if (isset($_POST['ip'])) {
    $ip = $_POST['ip'];
}

if (!is_dir('uploads/' . $newApp . '/' . $ccChannel)) {
    mkdir('uploads/' . $newApp . '/' . $ccChannel);
}
if (!is_dir('uploads/' . $QDE . '/' . $ccChannel)) {
    mkdir('uploads/' . $QDE . '/' . $ccChannel);
}

if (!is_dir('uploads/' . $newApp . '/' . $ccChannel . '/' . $ccCode)) {
    mkdir('uploads/' . $newApp . '/' . $ccChannel . '/' . $ccCode);
}
if (!is_dir('uploads/' . $QDE . '/' . $ccChannel . '/' . $ccCode)) {
    mkdir('uploads/' . $QDE . '/' . $ccChannel . '/' . $ccCode);
}

if (isset($_FILES['upFile'])) {
    move_uploaded_file($_FILES['upFile']['tmp_name'], "uploads/" . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['upFile']['name']);
    $dataObj->insertUploadInfo($ccCode, $_FILES['upFile']['name'], $upType, $ip);    
}
?>