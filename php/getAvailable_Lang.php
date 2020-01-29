<?php
$dir    = '../Locale';
$files1 = scandir($dir);
//$files2 = scandir($dir, 4);
echo json_encode($files1, JSON_UNESCAPED_UNICODE);

//print_r($files2);
?>