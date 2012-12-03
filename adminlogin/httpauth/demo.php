<?php
/*************************************************************************
php easy :: admin login scripts set - HTTP Authentication Version DEMO
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
require_once("login.php");

$authuser = $_SERVER['PHP_AUTH_USER'];
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
<p>Hello <?=$authuser;?>!</p>
<p>You have successfully logged in.</p>
<br>
<p>No logout:-(<br>
Simply close the browser window.</a></p>
</div>
</body>
</html>
