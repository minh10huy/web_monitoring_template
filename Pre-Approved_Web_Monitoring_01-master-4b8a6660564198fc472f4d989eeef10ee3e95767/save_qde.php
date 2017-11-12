<?php
session_start();
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
require_once 'lib/dao/VPBankDAO.php';
header('Content-Type: application/json');
$vpBank = new VPBankDAO();
$input = filter_input_array(INPUT_POST);

$qdetenkhachhang = isset($_POST['qdetenkhachhang']) ? str_replace("'", "",$_POST['qdetenkhachhang']) : "";
$qde_so_cmnd = isset($_POST['qde_so_cmnd']) ? str_replace("'", "",$_POST['qde_so_cmnd']) : "";
$qdeIdf1 = isset($_POST['qdeIdf1']) ? str_replace("'", "",$_POST['qdeIdf1']) : "";
$QDETypeCode = isset($_POST['QDETypeCode']) ? str_replace("'", "",$_POST['QDETypeCode']) : "";
$ErrorCode = isset($_POST['ErrorCode']) ? str_replace("'", "",$_POST['ErrorCode']) : "";
$reason= isset($_POST['qde_content']) ? str_replace("'", "",$_POST['qde_content']) : "";

$cc_code = $_SESSION['monitoring_username']; 

$test = $vpBank->insertQDE($cc_code, '', $qdeIdf1, $qde_so_cmnd, $qdetenkhachhang, $reason, 3, $ErrorCode, $QDETypeCode);

// Commnit if there are no errors
if ($test == 1) {
    echo json_encode('QDE successfully!');
    die;
    //echo 'Update data successfully';
} else {
    echo json_encode('QDE fail!');
    die;
    //echo 'Something wrong in database update';
}
?>



