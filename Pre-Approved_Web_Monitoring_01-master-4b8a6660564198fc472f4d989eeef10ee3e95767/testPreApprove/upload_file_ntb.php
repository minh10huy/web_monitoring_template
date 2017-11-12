<?php

session_start();
require_once 'lib/dao/VPBankDAO.php';

header('Content-Type: application/json');
$input = filter_input_array(INPUT_POST);

$current_year = date('Y');
$current_month = date('m');
$current_date = date('d');
$target_path = 'D:/HO_SO_MOI/';
$target_path_test = '/02_Input/HO_SO_MOI/';

if (!is_dir($target_path . $current_year)) {
    mkdir($target_path . $current_year);
}
if (!is_dir($target_path . $current_year . '/' . $current_month)) {
    mkdir($target_path . $current_year . '/' . $current_month);
}
if (!is_dir($target_path . $current_year . '/' . $current_month . '/' . $current_date)) {
    mkdir($target_path . $current_year . '/' . $current_month . '/' . $current_date);
}
if (!is_dir($target_path . $current_year . '/' . $current_month . '/' . $current_date . '/zip')) {
    mkdir($target_path . $current_year . '/' . $current_month . '/' . $current_date . '/zip');
}
if (!is_dir($target_path . $current_year . '/' . $current_month . '/' . $current_date . '/unzip')) {
    mkdir($target_path . $current_year . '/' . $current_month . '/' . $current_date . '/unzip');
}

$target_path_final_zip = $target_path . $current_year . '/' . $current_month . '/' . $current_date . '/zip';
$target_path_final_unzip = $target_path . $current_year . '/' . $current_month . '/' . $current_date . '/unzip';
$final_name = split('.zip', $_FILES['file']['name']);
$target_path_final_unzip_current_extract = $target_path_final_unzip . '/' . $final_name[0] . '/';

$pgSQL = new PostgreSQLClass();
$conn = $pgSQL->getConDPO_DIGISOFT();
if (!$conn) {
    echo 'There is error in connection with database';
    die();
}
$conn->beginTransaction();

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    die;
} else {
    try {
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $target_path_final_zip . '/' . $_FILES['file']['name'])) {
            echo 'Upload failed! Please contact admin system!';
            die;
        } else {
            $insert_data_download = "INSERT INTO db_16001_0001_bak_20160525.download (filename, folder_destination) VALUES ('" . $_FILES['file']['name'] . "', '$target_path_test'" . ") RETURNING id";
            $prepare = $conn->prepare($insert_data_download);
            $insert_data_download_result = $prepare->execute();
            $last_download_id = $prepare->fetch(PDO::FETCH_ASSOC);
            $zip = new ZipArchive;
            if ($zip->open($target_path_final_zip . '/' . $_FILES['file']['name']) === TRUE) {
                $zip->extractTo($target_path_final_unzip);
                $zip->close();
//                echo 'Extract ok'; die;

                $dh = opendir($target_path_final_unzip_current_extract);
                while (false !== ($filename = readdir($dh))) {
                    $files[] = $filename;
                }
                unset($files[0]);
                unset($files[1]);
                sort($files);

                for ($i = 0; $i < count($files); $i++) {
                    $dh1 = opendir($target_path_final_unzip_current_extract . $files[$i]);
                    unset($files1);
                    while (false !== ($filename1 = readdir($dh1))) {
                        $files1[] = $filename1;
                    }
                    unset($files1[0]);
                    unset($files1[1]);
                    sort($files1);

                    for ($j = 0; $j < count($files1); $j++) {
                        $final_file_path[] = $target_path_final_unzip_current_extract . $files[$i];
                        $final_file_name[] = $files1[$j];
                    }
                }
                for ($k = 0; $k < count($final_file_name); $k++) {
                    if ($k === count($final_file_name) - 1) {
                        $value_string = $value_string . "(" . $last_download_id["id"] . ", '" . $final_file_path[$k] . "', '" . $final_file_name[$k] . "')";
                    } else {
                        $value_string = $value_string . "(" . $last_download_id["id"] . ", '" . $final_file_path[$k] . "', '" . $final_file_name[$k] . "'), ";
                    }
                }

                $insert_data_management = "INSERT INTO db_16001_0001_bak_20160525.management (zip_id, filepath, filename) VALUES " . $value_string . " returning id";
                $prepare = $conn->prepare($insert_data_management);
                $insert_data_management_result = $prepare->execute();
                $last_mana_id = $prepare->fetch(PDO::FETCH_ASSOC);

                $value_string = '';
                for ($k = 0; $k < count($final_file_name); $k++) {
                    $newid = $last_mana_id["id"] + $k;
                    if ($k === count($final_file_name) - 1) {
                        $value_string = $value_string . "($newid, $newid)";
                    } else {
                        $value_string = $value_string . "($newid, $newid), ";
                    }
                }

                $insert_data_data = "INSERT INTO db_16001_0001_bak_20160525.data (id, management_id) VALUES " . $value_string;
                $prepare = $conn->prepare($insert_data_data);
                $insert_data_data_result = $prepare->execute();

                $insert_data_upload_info = "insert into db_16001_0001_bak_20160525.upload_info " . "(cc_code, file_name, type, ip) VALUES (" .
                        "'" . $_SESSION['monitoring_username'] . "', '" . $_FILES['file']['name'] . "', '" . 1 . "', '" . $_SERVER['REMOTE_ADDR'] . "')";
                $prepare = $conn->prepare($insert_data_upload_info);
                $insert_data_upload_info_result = $prepare->execute();

// Commnit if there are no errors
                if ($insert_data_download_result && $insert_data_management_result && $insert_data_data_result && $insert_data_upload_info_result) {
                    $conn->commit();
                    echo json_encode('Upload successfully!');
                    die;
                } else {
                    $conn->rollBack();
                    echo json_encode('Upload failed!');
                    die;
                    //echo 'Something wrong in database update';
                }
            } else {
                echo 'failed';
            }
//            $vpBank->insertUploadInfo($ccCode, $_FILES['uploadFile']['name'], $upType, $ip);
        }
    } catch (Exception $e) {
        die('File did not upload: ' . $e->getMessage());
    }
}
