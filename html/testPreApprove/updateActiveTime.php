<?php
require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';

$username = $_POST['username'];
$pgSQL = new PostgreSQLClass();
$conn = $pgSQL->getConDPO_DIGISOFT();
if (!$conn) {
    echo 'There is error in connection with database';
    die();
}

$conn->beginTransaction();

$update = "UPDATE db_16001_0001_bak_20160525.login_attempts SET lastlogin = NOW() WHERE username = '$username'";
$prepare = $conn->prepare($update);
$update_active_time = $prepare->execute();

if ($update_active_time) {
    $conn->commit();
    echo 'Update active time successfully';
} else {
    $conn->rollBack();
    echo 'Something wrong in database update';
}
?>
