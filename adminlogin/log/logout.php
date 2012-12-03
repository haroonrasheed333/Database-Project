<?php
session_start();
unset($_SESSION['login']);
$_SESSION['login'] = 'logout';
echo $_SESSION['login'];
session_destroy();
unset($_POST['submit']);
header('Location: login.php');
?>
