<?php
session_start();
require_once 'lib/dao/VPBankDAO.php';
header('Content-Type: application/json');
$vpBank = new VPBankDAO();
$input = filter_input_array(INPUT_POST);

$qdetenkhachhang = isset($_POST['qdetenkhachhang']) ? $_POST['qdetenkhachhang'] : "";
$qde_so_cmnd = isset($_POST['qde_so_cmnd']) ? $_POST['qde_so_cmnd'] : "";
$qdeIdf1 = isset($_POST['qdeIdf1']) ? $_POST['qdeIdf1'] : "";
$QDETypeCode = isset($_POST['QDETypeCode']) ? $_POST['QDETypeCode'] : "";
$ErrorCode = isset($_POST['ErrorCode']) ? $_POST['ErrorCode'] : "";
$qde_content = isset($_POST['qde_content']) ? $_POST['qde_content'] : "";

$cc_code = $_SESSION['monitoring_username'];    

$test = $vpBank->insertQDE($ccCode, '', $qdeIdf1, $qde_so_cmnd, $qdetenkhachhang, $qde_content, 3, $ErrorCode, $QDETypeCode);

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



