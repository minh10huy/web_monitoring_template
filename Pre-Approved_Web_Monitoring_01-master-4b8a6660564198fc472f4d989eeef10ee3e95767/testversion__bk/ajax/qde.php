<?php
// Start the session
session_start();
?>
<?php
$ccChannel = $_SESSION['monitoring_userchannel'];
$ccCode = $_SESSION['monitoring_username'];
$idF1 = filter_var($_POST['idF1'],FILTER_SANITIZE_STRING);
$upType = "HOSOBOSUNG";
$newApp = 'HOSOMOI';
$QDE = 'HOSOBOSUNG';
echo $idF1;die;
//if (isset($_POST['uploadQDE'])) {
    $target_path = "uploads/";
    if (!is_dir($target_path . $newApp)) {
        mkdir($target_path . $newApp);
    }
    if (!is_dir($target_path . $QDE)) {
        mkdir($target_path . $QDE);
    }
    if (!is_dir($target_path . $newApp . '/' . $ccChannel)) {
        mkdir($target_path . $newApp . '/' . $ccChannel);
    }
    if (!is_dir($target_path . $QDE . '/' . $ccChannel)) {
        mkdir($target_path . $QDE . '/' . $ccChannel);
    }

    if (!is_dir($target_path . $newApp . '/' . $ccChannel . '/' . $ccCode)) {
        mkdir($target_path . $newApp . '/' . $ccChannel . '/' . $ccCode);
    }
    if (!is_dir($target_path . $QDE . '/' . $ccChannel . '/' . $ccCode)) {
        mkdir($target_path . $QDE . '/' . $ccChannel . '/' . $ccCode);
    }
    try {
        //throw exception if can't move the file
        if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_path . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['uploadFile']['name'])) {
            throw new Exception('Could not move file');
        }

        echo "The file " . basename($_FILES['uploadFile']['name']) .
        " has been uploaded"; die;
//        echo( "<script type='text/javascript'>           
//                alert('The file has been uploaded');
//                </script> ");
    } catch (Exception $e) {
        die('File did not upload: ' . $e->getMessage());
    }
//}