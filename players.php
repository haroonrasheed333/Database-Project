<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>IPL 2012</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
	<link href='http://fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<div id="container">
		<div id="header">
      <div class="subnav">
        <ul id="nav" class="nav nav-pills">
          <li><a href="teams.php">Teams</a></li>
          <li class="active"><a href="players.php">Players</a></li>
          <li><a href="matches.php">Matches</a></li>
          <li><a href="venues.php">Venues</a></li>
          <li><a href="points.php">Points Table</a></li>
          <li><a href="scores.php">Scorecards</a></li>
          <li><a href="stats.php">Stats</a></li>
          <li><a href="admin.php">Admin</a></li>
        </ul>
      </div>
		</div>
    <form id="searchPlayer" method="post" accept-charset="utf-8">
      <label for="player-name" class="collapse">+ Search by Player Name</label>
      <input type="text" name="player-name" class="content">
      <label for="team-id" class="collapse">+ View all players of a Team </label>
      <select name="team-name" class="content">
        <option value="all">All Teams</option>
        <option value="mi">Mumbai Indians</option>
        <option value="csk">Chennai Super Kings</option>
        <option value="dd">Delhi Daredevils</option>
        <option value="kkr">Kolkata Knight Riders</option>
      </select> 
      <br>
      <br>
      <p><input id="sub" type="submit" class="btn" name= "submit-player" value="Submit"></p>
    </form>

    <?php
    if (!empty($_POST['submit-player'])) {
      mysql_connect("127.0.0.1","root","") or die("Could not connect: " . mysql_error());
      mysql_select_db("haroon");

      $name = $_POST['player-name'];
      $name = "%".$name."%";

      $team = $_POST['team-name'];

      if ($team == 'mi') {
        $team = 'Mumbai Indians';
      }
      elseif ($team == 'csk') {
        $team = 'Chennai Super Kings';
      }
      elseif ($team == 'dd') {
        $team = 'Delhi Daredevils';
      }
      elseif ($team == 'kp') {
        $team = 'Kings XI Punjab';
      }
      elseif ($team == 'kkr') {
        $team = 'Kolkata Knight Riders';
      }
      elseif ($team == 'pwi') {
        $team = 'Pune Warriors India';
      }
      elseif ($team == 'rr') {
        $team = 'Rajasthan Royals';
      }
      elseif ($team == 'rcb') {
        $team = 'RCB';
      }

      if (strlen($name) > 2) {
        $query = "SELECT p.Image, p.Player_Name, t.Team_Name, p.DOB, p.Nick_Name, t1.Team_Name AS Previous_Team, p.Matches, p.Batting_Style, p.Bowling_Style, p.Playing_Role, p.MOM FROM Teams t, Players p, teams t1 WHERE t.Team_ID = p.Team_ID AND t1.Team_ID = p.Previous_Team AND p.Player_Name LIKE '".mysql_real_escape_string($name)."'";
        $result = mysql_query($query);
        if (!$result) {
          die('Invalid query: ' . mysql_error());
        }
        while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
          echo "<table class='pltable1' border=0 cellpadding=0 cellspacing=0 width=350px>";
          echo "<tr>";
          $tmp = $r["Player_Name"];
          $tmp1 = $r["Image"];
          echo '<td width="75" height="100"><img class="img-polaroid" height="100px" src="data:image/jpeg;base64,' . base64_encode( $tmp1 ) . '" /></td>';
          echo "<td width='125' height='100' valign='top' class='pdetails'>";
          echo "<br><b>Name: </b>$tmp";
          $tmp = $r["Team_Name"];
          echo "<br><b>Team: </b>$tmp";
          $tmp = $r["DOB"];
          $tmp = date("d M, Y", strtotime($tmp));
          echo "<br><b>DOB: </b>$tmp";
          $tmp = $r["Nick_Name"];
          echo "<br><b>Nick Name: </b>$tmp";
          $tmp = $r["Batting_Style"];
          echo "<br><b>Batting: </b>$tmp";
          $tmp = $r["Bowling_Style"];
          echo "<br><b>Bowling: </b>$tmp";
          $tmp = $r["Playing_Role"];
          echo "<br><b>Role: </b>$tmp";
          echo "</td>";
          echo "</tr>";
          echo "</table>";
        }
      }
      else{
        if ($team == 'all') {
          $query = "SELECT p.Image, p.Player_Name, t.Team_Name, p.DOB, p.Nick_Name, t1.Team_Name AS Previous_Team, p.Matches, p.Batting_Style, p.Bowling_Style, p.Playing_Role, p.MOM FROM Teams t, Players p, teams t1 WHERE t.Team_ID = p.Team_ID AND t1.Team_ID = p.Previous_Team";
        }
        else {
          $query = "SELECT p.Image, p.Player_Name, t.Team_Name, p.DOB, p.Nick_Name, t1.Team_Name AS Previous_Team, p.Matches, p.Batting_Style, p.Bowling_Style, p.Playing_Role, p.MOM FROM Teams t, Players p, teams t1 WHERE t.Team_ID = p.Team_ID AND t1.Team_ID = p.Previous_Team AND t.Team_Name LIKE '".mysql_real_escape_string($team)."'";
        }

        $result = mysql_query($query);
        if (!$result) {
          die('Invalid query: ' . mysql_error());
        }

        echo "<br><br><table class='pltable' border=0 cellpadding=0 cellspacing=0 width=100%>";
      

        $num = 1;
        while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {

          if ($num+2 % 3 == 0){
            echo "$num";
            echo "<tr>";
          }   
          echo "<td>";
          echo "<table class='pltable' border=0 cellpadding=0 cellspacing=0 width=350px>";
          
          echo "<tr>";
          $tmp = $r["Player_Name"];
          $tmp1 = $r["Image"];
          echo '<td width="75" height="100"><img class="img-polaroid" height="100px" src="data:image/jpeg;base64,' . base64_encode( $tmp1 ) . '" /></td>';
          echo "<td width='125' height='100' valign='top' class='pdetails'>";
          echo "<br><b>Name: </b>$tmp";
          $tmp = $r["Team_Name"];
          echo "<br><b>Team: </b>$tmp";
          $tmp = $r["DOB"];
          $tmp = date("d M, Y", strtotime($tmp));
          echo "<br><b>DOB: </b>$tmp";
          $tmp = $r["Nick_Name"];
          echo "<br><b>Nick Name: </b>$tmp";
          $tmp = $r["Batting_Style"];
          echo "<br><b>Batting: </b>$tmp";
          $tmp = $r["Bowling_Style"];
          echo "<br><b>Bowling: </b>$tmp";
          $tmp = $r["Playing_Role"];
          echo "<br><b>Role: </b>$tmp";
          echo "</td>";
        	echo "</tr>";
          echo "</table>";
          echo "</td>";
          if ($num % 3 == 0){
            echo "</tr>";
          }  
          $num = $num+1;
        }
        echo "</table>";
      }
    }
  ?>
  </div>
</body>
</html>