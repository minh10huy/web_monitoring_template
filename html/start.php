<?PHP
$filename = 'sendemail.php';
//@ $fp = fopen("messages/".$filename, 'w');
//if (!$fp)
//{
//    echo '<p><strong>Cannot generate message file</strong></p></body></html>';
//    exit;
//} 
//else
//{
//echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa';
//echo "Hello World";

//function replace_string_in_file($filename, $curstr, $repstr){
//    $content=file_get_contents($filename);
//    $content_chunks=explode($curstr, $content);
//    $content=implode($repstr, $content_chunks);
//    file_put_contents($filename, $content);
//}

//$fp = fopen($filename, "a") or die("Couldn't open $file for writing!");

//$curstr  = '$.ajax({';
//$repstr = '<!--$.ajax({-->';

//read the entire string
$str=file_get_contents($filename);
echo $str;

//replace_string_in_file($filename, $curstr, $repstr);

//$str=str_replace($curstr,$repstr,$str); 
//echo $str;
//echo $str;
//fwrite($fp, $str);
//file_put_contents('$filename', $str);
//Echo "Message inserted";
//}


// a very beatiful way to do multiple replacements is this one, using just one array
$replaceThis = Array(
'flagsendmail = false;' => 'flagsendmail = true;',
);

$replacedText = str_replace(array_keys($replaceThis), $replaceThis, $str);
echo $replacedText;
file_put_contents($filename,$replacedText);

?>
