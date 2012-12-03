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
  				<li class="active"><a href="teams.php">Teams</a></li>
  				<li><a href="players.php">Players</a></li>
  				<li><a href="matches.php">Matches</a></li>
  				<li><a href="venues.php">Venues</a></li>
  				<li><a href="points.php">Points Table</a></li>
          <li><a href="scores.php">Scorecards</a></li>
          <li><a href="stats.php">Stats</a></li>
  				<li><a href="admin.php">Admin</a></li>
  			</ul>
      </div>
		</div>
    <?php
    mysql_connect("127.0.0.1","root","") or
      die("Could not connect: " . mysql_error());
    mysql_select_db("haroon");

    $result = mysql_query("SELECT t.Team_ID, t.Team_Name FROM teams t");
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }

    $num=1;
    $team[0] = '';

    while ($r = mysql_fetch_array($result,MYSQL_ASSOC)) {
      $team[$num] = $r["Team_Name"];
      $num = $num + 1;
    }
    ?>
    <form id="searchTeam" method="post" accept-charset="utf-8">
      <select name="teamname">
        <option>Select a team</option>
        <option value="all">All Teams</option>
      </select> 
      <br>
      <br>
      <p><input type="submit" class="btn" name= "submit-team" value="Submit"></p>
    </form>
    <script>
      var numm = "<?= $num ?>";
      <?php
      $js_team = json_encode($team);
      echo "var js_team = ". $js_team . ";\n";
      ?>
      for (i=1; i<numm; i++)
      {
        document.forms['searchTeam'].teamname.options[i+1] = new Option(js_team[i], js_team[i]);
      }
    </script>
		
    <?php
    if (!empty($_POST['submit-team'])) {
      mysql_connect("127.0.0.1","root","") or
      die("Could not connect: " . mysql_error());
      mysql_select_db("haroon");

      $team = $_POST['teamname'];

      if ($team == 'all'){
        $query = "SELECT t.Team_Name, t.Owner, t.Coach, t.Captain, v.Venue_Name, t.Best_Finish, t.Lowest_Finish, t.Net_Worth FROM Teams t, Venues v WHERE t.Venue_ID = v.Venue_ID";
      }
      else {
        $query = "SELECT t.Team_Name, t.Owner, t.Coach, t.Captain, v.Venue_Name, t.Best_Finish, t.Lowest_Finish, t.Net_Worth FROM Teams t, Venues v WHERE t.Venue_ID = v.Venue_ID AND t.Team_Name LIKE '".mysql_real_escape_string($team)."'";
      }

      $result = mysql_query($query);
      if (!$result) {
        die('Invalid query: ' . mysql_error());
      }

      echo "<br><br><table class='ttable' border=0 cellpadding=0 cellspacing=0 width=100%><tr class='theader'><td>Team Name</td><td>Owner</td>
      <td>Coach</td><td>Captain</td><td>Home Ground</td><td>Best Finish</td><td>Lowest Finish</td>
      <td>Net Worth</td></tr>";

      while ($r = mysql_fetch_array($result,MYSQL_ASSOC)) {
        echo "<tr>";
        $tmp = $r["Team_Name"];
        echo "<td>$tmp</td>";
        $tmp = $r["Owner"];
        echo "<td>$tmp</td>";
        $tmp = $r["Coach"];
        echo "<td>$tmp</td>";
        $tmp = $r["Captain"];
        echo "<td>$tmp</td>";
        $tmp = $r["Venue_Name"];
        echo "<td>$tmp</td>";
        $tmp = $r["Best_Finish"];
        echo "<td>$tmp</td>";
        $tmp = $r["Lowest_Finish"];
        echo "<td>$tmp</td>";
        $tmp = $r["Net_Worth"];
        echo "<td>$tmp</td>";
      	echo "</tr>";
      }
      echo "</table>";
    }
  ?>
  </div>
</body>
</html>