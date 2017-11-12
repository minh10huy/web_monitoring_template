<?php

session_start();

// DO NOT just copy from _POST to _SESSION,
// as it could allow a malicious user to override security.
// Use a disposable variable key, such as "data" here.
if (array_key_exists('mana_id', $_POST)) {
    $_SESSION['mana_id'] = null;
    $_SESSION['mana_id'] = $_POST['mana_id'];
    Header("Content-Type: application/json;charset=UTF-8");
    die(json_encode(array('status' => 'OK')));
}
//// This is safe (we move unsecurity-ward):
//$_POST['mana_id'] = $_SESSION['mana_id'];
//$_POST['zip_id'] = $_SESSION['zip_id'];
//$_POST['type'] = $_SESSION['type'];
//
//unset($_SESSION['mana_id']); // keep things clean.
//unset($_SESSION['zip_id']);
//unset($_SESSION['type']);
?>