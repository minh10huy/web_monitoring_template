<?php
// Start the session
session_start();
?>
<?php
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/..'),
    get_include_path()
)));
require_once ('../lib/dao/VPBankDAO.php');
require_once ('../model/User.php');

if (isset($_POST['username'])) {
    
    $username = $_POST['username'];
    $vpBank = new VPBankDAO();
//    $user = new User();
    
    // Kiểm tra password cũ có đúng với username này không
//    if(!$user->checkLogin($username)){
//        echo "error";
//        exit();
//    }
//    if($username == "admin" && !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/", $newPass)){
//        echo "Password must be between 8 to 15 characters
//                            \nwhich contain at least one lowercase letter,
//                            \none uppercase letter,
//                            \none numeric digit,
//                            \nand one special character";
//        exit();
//    }
    // Đổi password mới
    if($vpBank->resetPassword($username)){
        echo "success";
        exit();
    }
    echo "error";
}
?>