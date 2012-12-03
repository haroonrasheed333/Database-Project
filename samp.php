<?php
$newsURL = $_GET["url"];
$json_data = file_get_contents($newsURL);
echo $_GET['callback'] . '(' . ($json_data) . ')';
?>