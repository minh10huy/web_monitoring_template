<?php
header("Content-Type: text/html;charset=UTF-8");
session_start();
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
$mana_id = $_SESSION['mana_id'];
unset($_SESSION['mana_id']); // keep things clean.
if (isset($mana_id)) {
require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();
$file_info = $vpBank->get_file_path_by_id($mana_id[0]);
//echo $file_info[0]["filepath"].'/'.$file_info[0]["filename"];die;

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=".$file_info[0]["filename"]);
@readfile($file_info[0]["filepath"].'/'.$file_info[0]["filename"]);
}
?>