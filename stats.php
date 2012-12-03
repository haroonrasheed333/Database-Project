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
          <li><a href="players.php">Players</a></li>
          <li><a href="matches.php">Matches</a></li>
          <li><a href="venues.php">Venues</a></li>
          <li><a href="points.php">Points Table</a></li>
          <li><a href="scores.php">Scorecards</a></li>
          <li class="active"><a href="stats.php">Stats</a></li>
          <li><a href="admin.php">Admin</a></li>
        </ul>
      </div>
		</div>
    <?php
    mysql_connect("127.0.0.1","root","") or
      die("Could not connect: " . mysql_error());
    mysql_select_db("haroon");

    $result = mysql_query("SELECT p.Player_ID, p.Player_Name FROM players p");
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }

    $num=1;
    $player[0] = '';
    $playerid[0] = '';

    while ($r = mysql_fetch_array($result,MYSQL_ASSOC)) {
      $player[$num] = $r["Player_Name"];
      $playerid[$num] = $r["Player_ID"];
      $num = $num + 1;
    }
    ?>
    <form id="statForm" method="post" accept-charset="utf-8">
      <select name="player">
        <option>Select a player</option>
      </select> 
      <select name="stat">
        <option value="ipl">Tournament Stats</option>
        <option value="career">Career Stats</option>
      </select> 
      <br>
      <br>
      <p><input id="sub" type="submit" class="btn" name= "submit-stat" value="Submit"></p>
    </form>
    <script>
      var numm = "<?= $num ?>";
      <?php
      $js_player = json_encode($player);
      $js_playerid = json_encode($playerid);
      echo "var js_player = ". $js_player . ";\n";
      echo "var js_playerid = ". $js_playerid . ";\n";
      ?>
      for (i=1; i<numm; i++)
      {
        document.forms['statForm'].player.options[i] = new Option(js_player[i], js_playerid[i]);
      }
    </script>

    <?php
    if (!empty($_POST['submit-stat'])) {
      mysql_connect("127.0.0.1","root","") or die("Could not connect: " . mysql_error());
      mysql_select_db("haroon");

      $pID = $_POST['player'];
      $stat = $_POST['stat'];

      if ($stat == 'career'){
        $query = "SELECT p.Image, p.Player_Name, ba.Matches_Played, ba.Runs, ba.Highest_Score, ba.Not_Outs, 
        ba.50s, ba.100s FROM career_batting_stat ba, Players p WHERE p.Player_ID = ba.Player_ID AND ba.Player_ID = '$pID'";
        $result = mysql_query($query);
        if (!$result) {
          die('Invalid query: ' . mysql_error());
        }
        while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
          echo "<table class='sttable1' border=0 cellpadding=0 cellspacing=0 width=500px height=400px>";
          echo "<tr>";
          $tmp = $r["Player_Name"];
          $tmp1 = $r["Image"];
          echo '<td height="400" class=image><img class="img-polaroid" height="300px" src="data:image/jpeg;base64,' . base64_encode( $tmp1 ) . '" /></td>';
          echo "<td width='200' height='400' class='pdetails'>";
          echo "<h3>Career Stats</h3>";
          echo "<h3>Batting</h3>";
          echo "<b>Name: </b>$tmp";
          $tmp = $r["Matches_Played"];
          echo "<br><b>Matches: </b>$tmp";
          $tmp = $r["Runs"];
          echo "<br><b>Runs: </b>$tmp";
          $tmp = $r["Highest_Score"];
          echo "<br><b>Highest: </b>$tmp";
          $tmp = $r["Not_Outs"];
          echo "<br><b>Not Outs: </b>$tmp";
          $tmp = $r["50s"];
          echo "<br><b>50s: </b>$tmp";
          $tmp = $r["100s"];
          echo "<br><b>100s: </b>$tmp";
        }
        $temp = 0;
        $query1 = "SELECT bo.Balls_Bowled, bo.Runs_Conceded, bo.Wickets, bo.Best_Figure FROM career_bowling_stat bo WHERE bo.Player_ID = '$pID'";
        $result1 = mysql_query($query1);
        if (!$result1) {
          die('Invalid query: ' . mysql_error());
        }
        while ($r = mysql_fetch_array($result1, MYSQL_ASSOC)) {
          $temp = 1;
          echo "<h3>Bowling</h3>";
          $tmp = intval($r["Balls_Bowled"]);
          $tmp = intval($tmp / 6);
          echo "<b>Overs: </b>$tmp";
          $tmp = intval($r["Runs_Conceded"]);
          echo "<br><b>Runs Conceded: </b>$tmp";
          $tmp = intval($r["Wickets"]);
          echo "<br><b>Wickets: </b>$tmp";
          $tmp = $r["Best_Figure"];
          echo "<br><b>Best Figure: </b>$tmp";
          echo "</td>";
          echo "</tr>";
          echo "</table>";
        }
        if ($temp == 0){
          echo "<h3>Bowling</h3>";
          echo "<b>Overs: </b>0";
          echo "<br><b>Runs Conceded: </b>0";
          echo "<br><b>Wickets: </b>0";
          echo "<br><b>Best Figure: </b>0/0";
        }
      }
      elseif ($stat == 'ipl'){
        $query = "SELECT p.Player_Name, p.Image, t.Team_Name, COUNT(bt.Player_ID) AS Matches, SUM(bt.Balls_Faced), 
        SUM(bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) AS Runs, 
        MAX(bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) AS Highest,
        SUM(CASE WHEN bt.Dismissal_Type = 'Not out' THEN 1 ELSE 0 END) AS Not_Outs,
        SUM(CASE WHEN (bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) > 100 THEN 1 ELSE 0 END) AS 100s,
        SUM(CASE WHEN ((bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) > 50 AND (bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) < 100) THEN 1 ELSE 0 END) AS 50s
         FROM players p, player_match_batting bt,
        teams t WHERE p.Player_ID = bt.Player_ID AND t.Team_ID = bt.Team_ID AND bt.Player_ID = '$pID'";
        $result = mysql_query($query);
        if (!$result) {
          die('Invalid query: ' . mysql_error());
        }

        while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
          echo "<table class='sttable1' border=0 cellpadding=0 cellspacing=0 width=500px height=400px>";
          echo "<tr>";
          $tmp = $r["Player_Name"];
          $tmp1 = $r["Image"];
          echo '<td height="400" class=image><img class="img-polaroid" height="300px" src="data:image/jpeg;base64,' . base64_encode( $tmp1 ) . '" /></td>';
          echo "<td width='200' height='400' class='pdetails'>";
          echo "<h3>Tournament Stats</h3>";
          echo "<h3>Batting</h3>";
          echo "<b>Name: </b>$tmp";
          $tmp = intval($r["Matches"]);
          echo "<br><b>Matches: </b>$tmp";
          $tmp = intval($r["Not_Outs"]);
          echo "<br><b>Not Outs: </b>$tmp";
          $tmp = intval($r["Runs"]);
          echo "<br><b>Runs: </b>$tmp";
          $tmp = intval($r["Highest"]);
          echo "<br><b>Highest: </b>$tmp";
          $tmp = intval($r["50s"]);
          echo "<br><b>50s: </b>$tmp";
          $tmp = intval($r["100s"]);
          echo "<br><b>100s: </b>$tmp";
        }

        $temp = 0;
        $query1 = "SELECT COUNT(bo.Player_ID) AS Matches, SUM(bo.Overs) AS Overs, SUM(bo.Runs_Conceded) AS Runs_Conceded, 
        SUM(bo.Wickets) AS Wickets FROM player_match_bowling bo WHERE bo.Player_ID = '$pID'";
        $result1 = mysql_query($query1);
        if (!$result1) {
          die('Invalid query: ' . mysql_error());
        }

        while ($r = mysql_fetch_array($result1, MYSQL_ASSOC)) {
          $temp = 1;
          echo "<h3>Bowling</h3>";
          $tmp = intval($r["Matches"]);
          echo "<b>Matches Bowled: </b>$tmp";
          $tmp = intval($r["Overs"]);
          echo "<br><b>Overs: </b>$tmp";
          $tmp = intval($r["Runs_Conceded"]);
          echo "<br><b>Runs Conceded: </b>$tmp";
          $tmp = intval($r["Wickets"]);
          echo "<br><b>Wickets: </b>$tmp";
        }
        if ($temp == 0){
          echo "<br><b>Matches Bowled: </b>0";
          echo "<br><b>Overs: </b>0";
          echo "<br><b>Runs Conceded: </b>0";
          echo "<br><b>Wickets: </b>0";
        }

          echo "</td>";
          echo "</tr>";
          echo "</table>";
      }
    }
  ?>
  </div>
</body>
</html>