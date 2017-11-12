<?php
session_start();
if (array_key_exists('FromDate', $_POST)) {
    $_SESSION['FromDate'] = $_POST['FromDate'];
    $_SESSION['ToDate'] = $_POST['ToDate'];
    $_SESSION['type_input'] = $_POST['type_input'];
    Header("Content-Type: application/json;charset=UTF-8");
    die(json_encode(array('status' => 'OK')));
}
////// This is safe (we move unsecurity-ward):
//$_POST['FromDate'] = $_SESSION['FromDate'];
//$_POST['ToDate'] = $_SESSION['ToDate'];
//$_POST['type_input'] = $_SESSION['type_input'];
//
//unset($_SESSION['FromDate']); // keep things clean.
//unset($_SESSION['ToDate']);
//unset($_SESSION['type_input']);