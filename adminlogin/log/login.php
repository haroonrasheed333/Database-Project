<?php
session_start();
require 'include.php';
if (isset($_POST['submit']) || isset($_SESSION['login'])) {
	if (isset($_SESSION['login'])) {
		if ($_SESSION['login'] == $hash) {
			echo "<p align=center><font size=4>Logged In!</font></p><p align=left><a href=logout.php>Logout</a><BR><BR></p>";
		} 
		else {
			echo "Bad SESSION. Clear them out and try again.";
		}
	} 
	else {
		if ($_POST['user'] == $user && $_POST['pass'] == $pass){
			$_SESSION["login"] = $hash;
			header("Location: $_SERVER[PHP_SELF]");
		} 
		else {
			echo "incorrect user/pass";
		}
	}
}
else {
	print "<form action=";
	echo "$self "; 
	print "method=post>Login<fieldset><BR>Username: <input type=text name=user><BR>
	Password: <input type=password name=pass><BR><input type=submit name=submit value=submit></fieldset></form>";
}
?>
