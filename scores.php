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
	  				<li><a href="venues.php">Venues</a></li>
	  				<li><a href="points.php">Points Table</a></li>
	          		<li class="active"><a href="scores.php">Scorecards</a></li>
	          		<li><a href="stats.php">Stats</a></li>
	  				<li><a href="admin.php">Admin</a></li>
	  			</ul>
      		</div>
		</div>

		<?php
		mysql_connect("127.0.0.1","root","") or
   		die("Could not connect: " . mysql_error());
		mysql_select_db("haroon");

		$result = mysql_query("SELECT m.Match_ID, m.Date, t.Team_Name AS Team1, t1.Team_Name AS Team2 
			FROM matches m, teams t1, teams t WHERE t.Team_ID = m.Team1 AND t1.Team_ID = m.Team2");
		if (!$result) {
  			die('Invalid query: ' . mysql_error());
		}

		$num=1;
		$matid[0] = '';
		$date[0] = '';
		$teams [0] = '';
		$teamsfull [0] = '';

		while ($r = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$matid[$num] = $r["Match_ID"];
			$date[$num] = date("d M,y", strtotime($r["Date"]));
			$team1 = explode(" ", $r["Team1"]);
			$team2 = explode(" ", $r["Team2"]);
			$teams[$num] = $team1[0] . " vs. " . $team2[0];
			$teamsfull[intval($r["Match_ID"])] = $r["Team1"] . " vs. " . $r["Team2"];
			$num = $num + 1;
		}
		?>

		<form id="matchScore" method="post" accept-charset="utf-8">
	      	<select name="matches">
	      		<option>Select a match</option>
	      	</select> 
	      	<br>
	      	<br>
	      	<p><input type="submit" class="btn" name= "submit-score" value="Submit"></p>
    	</form> 
		<script>
			var numm = "<?= $num ?>";
			<?php
			$js_matid = json_encode($matid);
			$js_date = json_encode($date);
			$js_teams = json_encode($teams);
			echo "var js_matid = ". $js_matid . ";\n";
			echo "var js_date = ". $js_date . ";\n";
			echo "var js_teams = ". $js_teams . ";\n";
			?>
			for (i=1; i<numm; i++)
			{
				//document.forms['matchScore'].matches.options[i] = new Option(i,i.toString());
				document.forms['matchScore'].matches.options[i] = new Option('M'+js_matid[i]+' - '+ js_date[i].toString()+' '+js_teams[i], js_matid[i]);
			}
		</script>
		<?php
		if (!empty($_POST['submit-score'])) {

	  		mysql_connect("127.0.0.1","root","") or
	   		die("Could not connect: " . mysql_error());
			mysql_select_db("haroon");

			$match = $_POST['matches'];

			$result = mysql_query("SELECT Team1, Team2, Field_First FROM matches WHERE Match_ID = '".$match."'");

			if (!$result) {
	  			die('Invalid query: ' . mysql_error());
			}

			$team1 = '';
			$team2 = '';
			$fieldfirst = '';

			while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
	  			$team1 = $r["Team1"];
	  			$team2 = $r["Team2"];
	  			$fieldfirst = $r["Field_First"];

	 		}

	 		if ($fieldfirst == $team1) {
	 			$team1 = $team2;
	 			$team2 = $fieldfirst;
	 		}

	 		$query = "SELECT p.Player_Name, (bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) AS Runs, bt.Balls_Faced,  
	 		bt.Balls_Faced, Round(((bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6)/bt.Balls_Faced*100),2) AS Strike_Rate,
	 		bt.Fours, bt.Sixes, CASE WHEN bt.Dismissed_By IS NULL
	 							THEN bt.Dismissal_Type
	 							ELSE p1.Player_Name END AS Dismissed_By, bt.Dismissal_Type FROM player_match_batting bt, players p, 
			players p1 WHERE bt.Player_ID = p.Player_ID AND ((bt.Dismissed_By > 0 AND bt.Dismissed_By = p1.Player_ID) OR bt.Dismissed_By IS NULL)
		 	AND bt.Team_ID = '$team1' AND bt.Match_ID = '$match' GROUP BY p.Player_Name ORDER BY p.Player_ID";

	 		$res = mysql_query($query);
	 		
	 		if (!$res) {
	  			die('Invalid query: ' . mysql_error());
			}

			echo "<h1>$teamsfull[$match]</h1>";
			echo "<br><br><table class='stable' border=0 cellpadding=0 cellspacing=0 width=100%><tr class='theader'><td>Player Name</td><td>Runs</td><td>Balls</td><td>Strike Rate</td>
			<td>Fours</td><td>Sixes</td><td>Dismissed_By</td><td>Dismissal Type</td></tr>";

			while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
				echo "<tr>";
				$tmp = $r["Player_Name"];
				echo "<td>$tmp</td>";
				$tmp = $r["Runs"];
				echo "<td>$tmp</td>";
				$tmp = $r["Balls_Faced"];
				echo "<td>$tmp</td>";
				$tmp = $r["Strike_Rate"];
	  			if ($tmp == ''){
	  				$tmp = 0.00;
	  			}

				echo "<td>$tmp</td>";
				$tmp = $r["Fours"];
				echo "<td>$tmp</td>";
				$tmp = $r["Sixes"];
				echo "<td>$tmp</td>";
				$tmp = $r["Dismissed_By"];
				echo "<td>$tmp</td>";
				$tmp = $r["Dismissal_Type"];
				echo "<td>$tmp</td>";
				echo "</tr>";
			}
			echo "</table>";

			$query = "SELECT p.Player_Name, bo.Overs, bo.Maidens, bo.Runs_Conceded, bo.No_Balls, bo.Wides, 
			bo.Byes, bo.Leg_Byes, bo.Other_Extras, bo.Wickets,  ROUND((bo.Runs_Conceded / bo.Overs),2) AS Economy_Rate 
			FROM player_match_bowling bo, players p WHERE bo.Player_ID = p.Player_ID AND bo.Team_ID = '$team2' 
			AND bo.Match_ID = '$match' GROUP BY p.Player_Name ORDER BY p.Player_ID";

	 		$res = mysql_query($query);
	 		
	 		if (!$res) {
	  			die('Invalid query: ' . mysql_error());
			}

			echo "<br><br><table class='stable' border=0 cellpadding=0 cellspacing=0 width=100%><tr class='theader'><td>Player Name</td>
			<td>Overs</td><td>Maidens</td><td>Runs Conceded</td><td>No_Balls</td><td>Wides</td><td>Byes</td><td>Leg Byes</td>
			<td>Other Extras</td><td>Wickets</td><td>Economy_Rate</td></tr>";

			while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
				echo "<tr>";
				$tmp = $r["Player_Name"];
				echo "<td>$tmp</td>";
				$tmp = $r["Overs"];
				echo "<td>$tmp</td>";
				$tmp = $r["Maidens"];
				echo "<td>$tmp</td>";
				$tmp = $r["Runs_Conceded"];
	  			echo "<td>$tmp</td>";
				$tmp = $r["No_Balls"];
				echo "<td>$tmp</td>";
				$tmp = $r["Wides"];
				echo "<td>$tmp</td>";
				$tmp = $r["Byes"];
				echo "<td>$tmp</td>";
				$tmp = $r["Leg_Byes"];
				echo "<td>$tmp</td>";
				$tmp = $r["Other_Extras"];
				echo "<td>$tmp</td>";
				$tmp = $r["Wickets"];
				echo "<td>$tmp</td>";
				$tmp = $r["Economy_Rate"];
				echo "<td>$tmp</td>";
				echo "</tr>";
			}
			echo "</table>";

			$query = "SELECT p.Player_Name, (bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) AS Runs, bt.Balls_Faced,  
	 		bt.Balls_Faced, Round(((bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6)/bt.Balls_Faced*100),2) AS Strike_Rate,
	 		bt.Fours, bt.Sixes, CASE WHEN bt.Dismissed_By IS NULL
	 							THEN bt.Dismissal_Type
	 							ELSE p1.Player_Name END AS Dismissed_By, bt.Dismissal_Type FROM player_match_batting bt, players p, 
			players p1 WHERE bt.Player_ID = p.Player_ID AND ((bt.Dismissed_By > 0 AND bt.Dismissed_By = p1.Player_ID) OR bt.Dismissed_By IS NULL)
		 	AND bt.Team_ID = '$team2' AND bt.Match_ID = '$match' GROUP BY p.Player_Name ORDER BY p.Player_ID";

	 		$res = mysql_query($query);
	 		
	 		if (!$res) {
	  			die('Invalid query: ' . mysql_error());
			}

			echo "<br><br><table class='stable' border=0 cellpadding=0 cellspacing=0 width=100%><tr class='theader'><td>Player Name</td>
			<td>Runs</td><td>Balls</td><td>Strike Rate</td><td>Fours</td><td>Sixes</td><td>Dismissed_By</td>
			<td>Dismissal Type</td></tr>";

			while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
				echo "<tr>";
				$tmp = $r["Player_Name"];
				echo "<td>$tmp</td>";
				$tmp = $r["Runs"];
				echo "<td>$tmp</td>";
				$tmp = $r["Balls_Faced"];
				echo "<td>$tmp</td>";
				$tmp = $r["Strike_Rate"];
	  			if ($tmp == ''){
	  				$tmp = 0.00;
	  			}

				echo "<td>$tmp</td>";
				$tmp = $r["Fours"];
				echo "<td>$tmp</td>";
				$tmp = $r["Sixes"];
				echo "<td>$tmp</td>";
				$tmp = $r["Dismissed_By"];
				echo "<td>$tmp</td>";
				$tmp = $r["Dismissal_Type"];
				echo "<td>$tmp</td>";
				echo "</tr>";
			}
			echo "</table>";

			$query = "SELECT p.Player_Name, bo.Overs, bo.Maidens, bo.Runs_Conceded, bo.No_Balls, bo.Wides, 
			bo.Byes, bo.Leg_Byes, bo.Other_Extras, bo.Wickets, ROUND((bo.Runs_Conceded / bo.Overs),2) AS Economy_Rate 
			FROM player_match_bowling bo, players p WHERE bo.Player_ID = p.Player_ID AND bo.Team_ID = '$team1' 
			AND bo.Match_ID = '$match' GROUP BY p.Player_Name ORDER BY p.Player_ID";

	 		$res = mysql_query($query);
	 		
	 		if (!$res) {
	  			die('Invalid query: ' . mysql_error());
			}

			echo "<br><br><table class='stable' border=0 cellpadding=0 cellspacing=0 width=100%><tr class='theader'><td>Player Name</td>
			<td>Overs</td><td>Maidens</td><td>Runs Conceded</td><td>No_Balls</td><td>Wides</td><td>Byes</td><td>Leg Byes</td>
			<td>Other Extras</td><td>Wickets</td><td>Economy Rate</td></tr>";

			while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
				echo "<tr>";
				$tmp = $r["Player_Name"];
				echo "<td>$tmp</td>";
				$tmp = $r["Overs"];
				echo "<td>$tmp</td>";
				$tmp = $r["Maidens"];
				echo "<td>$tmp</td>";
				$tmp = $r["Runs_Conceded"];
	  			echo "<td>$tmp</td>";
				$tmp = $r["No_Balls"];
				echo "<td>$tmp</td>";
				$tmp = $r["Wides"];
				echo "<td>$tmp</td>";
				$tmp = $r["Byes"];
				echo "<td>$tmp</td>";
				$tmp = $r["Leg_Byes"];
				echo "<td>$tmp</td>";
				$tmp = $r["Other_Extras"];
				echo "<td>$tmp</td>";
				$tmp = $r["Wickets"];
				echo "<td>$tmp</td>";
				$tmp = $r["Economy_Rate"];
				echo "<td>$tmp</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		?>
	</div>
</body>
</html>