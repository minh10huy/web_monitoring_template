<?php
session_start();
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
require_once 'lib/dao/CRCDAO.php';
header('Content-Type: application/json');
$vpBank = new CRCDAO();

$mana_id = isset($_POST['management_id']) ? str_replace("'", "",$_POST['management_id']) : "";
$qde_mana_id = isset($_POST['qde_managementid']) ? str_replace("'", "",$_POST['qde_managementid']) : "";
$cc_code = $_SESSION['monitoring_username']; 

$result = $vpBank->cancel_qde($mana_id, $qde_mana_id);

// Commnit if there are no errors
if ($result) {
    echo json_encode('Cancel QDE successfully!');
    die;
    //echo 'Update data successfully';
} else {
    echo json_encode('Cancel QDE fail!');
    die;
    //echo 'Something wrong in database update';
}
?>



