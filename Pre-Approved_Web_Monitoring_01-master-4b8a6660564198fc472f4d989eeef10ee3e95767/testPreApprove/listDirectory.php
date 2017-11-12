<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$newApp = 'HOSOMOI';
$QDE = 'HOSOBOSUNG';

$ccCode = '';
$ccChannel = '';
$type = '';

if (isset($_GET['ccCode'])) {
    $ccCode = $_GET['ccCode'];
}
if (isset($_GET['ccChannel'])) {
    $ccChannel = $_GET['ccChannel'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

function getFileList($dir) {
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if (substr($dir, -1) != "/")
        $dir .= "/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while (false !== ($entry = $d->read())) {
        // skip hidden files
        if ($entry[0] == ".")
            continue;
        if (is_dir("$dir$entry")) {
            $retval[] = array(
                "name" => "$dir$entry/",
                "type" => filetype("$dir$entry"),
                "size" => 0,
                "lastmod" => filemtime("$dir$entry")
            );
        } elseif (is_readable("$dir$entry")) {
            $retval[] = array(
                "name" => "$dir$entry",
                "type" => mime_content_type("$dir$entry"),
                "size" => filesize("$dir$entry"),
                "lastmod" => filemtime("$dir$entry")
            );
        }
    }
    $d->close();

    return $retval;
}

function dirToArray($dir) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

if (count_chars($type) > 0) {
    $path = 'uploads/' . $type . '/' . $ccChannel . '/' . $ccCode;
    if (is_dir($path)) {
        //$listdir = getFileList($path);    
        $listdir = scandir($path);
        //print_r($listdir);
        //echo "<pre>",print_r($listdir),"</pre>";
    }else{
        $listdir = array();
    }
}
/* Output header */
header('Content-type: application/json');
echo json_encode($listdir);
