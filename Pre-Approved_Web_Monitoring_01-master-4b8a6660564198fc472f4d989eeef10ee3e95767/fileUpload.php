
<?php


//ini_set('upload_max_filesize', '10M');
//ini_set('post_max_size', '10M');
//ini_set('max_input_time', 300);
//ini_set('max_execution_time', 300);

echo $_FILES['upFile']['name'] . '<br/>'; die;
//$target_path = "uploads/";//uploads\HOSOBOSUNG\DSNTB\CC104246
$target_path = "uploads/". basename($_FILES['upFile']['name']);
//$temp = explode(".", $_FILES["upFile"]["name"]);
//$newfilename = round(microtime(true)) . '.' . end($temp);
//$target_path = $target_path . basename($_FILES['upFile']['name']);
//$target_path = $target_path . $newfilename;

try {
    //throw exception if can't move the file
    if (!move_uploaded_file($_FILES['upFile']['tmp_name'], $target_path)) {
        throw new Exception('Could not move file');
    }

    echo "The file " . basename($_FILES['upFile']['name']) .
    " has been uploaded";
} catch (Exception $e) {
    die('File did not upload: ' . $e->getMessage());
}
?>