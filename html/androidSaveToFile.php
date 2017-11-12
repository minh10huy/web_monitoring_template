<?php

require_once 'AndroidDigiUploadDataObj.php';
$dataObj = new AndroidDigiUploadDataObj();
//echo $_FILES['upFile']['name'] . '<br/>';

$ccCode = '';
$ccChannel = '';
$upType = '';
//$ip = '';
$reason = '';
$cus_id = '';
$cus_name = '';
$idf1 = '';
//include_once('customdemo/confi.php');
//$today = date("d_m_Y");
$newApp = 'HOSOMOI';
$QDE = 'HOSOBOSUNG';

if (!is_dir('uploads/mobiuploads/' . $newApp)) {
    mkdir('uploads/mobiuploads/' . $newApp);
}
if (!is_dir('uploads/mobiuploads/' . $QDE)) {
    mkdir('uploads/mobiuploads/' . $QDE);
}

if (isset($_POST['ccCode'])) {
    $ccCode = $_POST['ccCode'];
}
if (isset($_POST['ccChannel'])) {
    $ccChannel = $_POST['ccChannel'];
}
if (isset($_POST['upType'])) {
    $upType = $_POST['upType'];
}
if (isset($_POST['reason'])) {
    $reason = $_POST['reason'];
}
if (isset($_POST['cus_id'])) {
    $cus_id = $_POST['cus_id'];
}
if (isset($_POST['cus_name'])) {
    $cus_name = $_POST['cus_name'];
}
if (isset($_POST['idf1'])) {
    $idf1 = $_POST['idf1'];
}
$results = $dataObj->checkAndroidRole($ccCode);
if (count($results) > 0) {
    if (!is_dir('uploads/mobiuploads/' . $newApp . '/' . $ccChannel)) {
        mkdir('uploads/mobiuploads/' . $newApp . '/' . $ccChannel);
    }
    if (!is_dir('uploads/mobiuploads/' . $QDE . '/' . $ccChannel)) {
        mkdir('uploads/mobiuploads/' . $QDE . '/' . $ccChannel);
    }

    if (!is_dir('uploads/mobiuploads/' . $newApp . '/' . $ccChannel . '/' . $ccCode)) {
        mkdir('uploads/mobiuploads/' . $newApp . '/' . $ccChannel . '/' . $ccCode);
    }
    if (!is_dir('uploads/mobiuploads/' . $QDE . '/' . $ccChannel . '/' . $ccCode)) {
        mkdir('uploads/mobiuploads/' . $QDE . '/' . $ccChannel . '/' . $ccCode);
    }

    if ($upType == $newApp) {
        if (isset($_FILES['upFile'])) {
            if (move_uploaded_file($_FILES['upFile']['tmp_name'], "uploads/mobiuploads/" . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['upFile']['name'])) {
                if (file_exists("uploads/mobiuploads/" . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['upFile']['name'])) {
                    $dataObj->insertUploadInfo($ccCode, $_FILES['upFile']['name'], $upType);
                }
            }
        }
    } elseif ($upType == $QDE) {
        if (isset($_FILES['upFile'])) {
            if (move_uploaded_file($_FILES['upFile']['tmp_name'], "uploads/mobiuploads/" . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['upFile']['name'])) {
                if (file_exists("uploads/mobiuploads/" . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['upFile']['name'])) {
                    $dataObj->insertQDE($ccCode, basename($_FILES['upFile']['name']), $idf1, $cus_id, $cus_name, $reason);
                }
            }
        } else {
            $dataObj->insertQDE($ccCode, '', $idf1, $cus_id, $cus_name, $reason);
        }
    }
}
?>