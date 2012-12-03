<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>IPL 2012</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link href='http://fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="subnav">
	  			<ul id="nav" class="nav nav-pills">
	  				<li><a href="teams.php">Teams</a></li>
	  				<li><a href="players.php">Players</a></li>
	  				<li><a href="matches.php">Matches</a></li>
	  				<li class="active"><a href="venues.php">Venues</a></li>
	  				<li><a href="points.php">Points Table</a></li>
	          		<li><a href="scores.php">Scorecards</a></li>
	          		<li><a href="stats.php">Stats</a></li>
	  				<li><a href="admin.php">Admin</a></li>
	  			</ul>
      		</div>
		</div>
		<table class="vtable" border=0 cellpadding=0 cellspacing=0 width=40%>
			<tr class="theader">
				<td>Venue Name</td>
				<td>Capacity</td>
				<td>No. of Matches</td>
			</tr>

			<?php

			mysql_connect("127.0.0.1","root","") or die("Could not connect: " . mysql_error());
			mysql_select_db("haroon");

			$query = "SELECT v.Venue_Name , v.Capacity, COUNT(m.Venue_ID) AS Num_Matches FROM venues v, matches m 
			WHERE v.Venue_ID = m.Venue_ID GROUP BY v.Venue_ID";

			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}


			while ($r = mysql_fetch_array($result,MYSQL_ASSOC)) {
				echo "<tr>";
			  	$tmp = $r["Venue_Name"];
			  	echo "<td>$tmp</td>";
			  	$tmp = $r["Capacity"];
			  	echo "<td>$tmp</td>";
			  	$tmp = $r["Num_Matches"];
			  	echo "<td>$tmp</td>";
				echo "</tr>";
			 }

			?>
		</table>
	</div>
</body>
</html>