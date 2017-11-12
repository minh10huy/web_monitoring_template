<?php
// Start the session
session_start();
require_once 'model/User.php';
require_once 'lib/define/constants.php';
?>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_SESSION['monitoring_username'])) { 
    // Update login status
    $user = new User();
    $user->updateLoginStatus($_SESSION['monitoring_username']);
    session_unset();
    header('Location: index.php');
}
header('Location: index.php');
?>