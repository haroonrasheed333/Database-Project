<?php
/*************************************************************************
php easy :: admin login scripts set - Session Version DEMO
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
require_once("login.php");

if (isset($_SESSION['authuser'])){
	$authuser = $_SESSION['authuser'];
}
?>
<html>
<head>
<title>Admin Page</title>
<style type="text/css">
body {
font-family: "Verdana", sans-serif;
font-size: 9pt;
}
</style>
<body>
<div align="center">
<br>
<h1>Admin Page</h1>
<p>You have successfully logged in.</p>
<br>
<p><a href="login.php?logout">Logout</a></p>
</div>
</body>
</html>
