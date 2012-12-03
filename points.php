<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>IPL 2012</title>
  <link rel="stylesheet" type="text/css" href="bootstrap.css" />
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
          <li class="active"><a href="points.php">Points Table</a></li>
          <li><a href="scores.php">Scorecards</a></li>
          <li><a href="stats.php">Stats</a></li>
          <li><a href="admin.php">Admin</a></li>
        </ul>
      </div>
		</div>
		<table class="ptable" border=0 cellpadding=0 cellspacing=0 width=110%>
<tr class="theader">
<td>Team Name</td>
<td>Matches Played</td>
<td>Matches Won</td>
<td>Matches Lost</td>
<td>Points</td>
</tr>


<?php

mysql_connect("127.0.0.1","root","") or
die("Could not connect: " . mysql_error());
mysql_select_db("haroon");

$query = "SELECT m.Match_ID, m.Date, m.Team1, m.Team2, t1.Team_Name AS Team1_Name, t2.Team_Name AS Team2_Name, v.Venue_Name, 
t3.Team_Name AS Field_First, p.Player_Name FROM matches m, teams t1, teams t2, teams t3, venues v, players p WHERE t1.Team_ID = m.Team1 
AND t2.Team_ID = m.Team2 AND t3.Team_ID = m.Field_First AND v.Venue_ID = m.Venue_ID AND p.Player_ID = m.MOM ORDER BY m.Match_ID";

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

$team1name = '';
$team2name = '';
$fieldfirst = '';
$batfirst = '';

$miMatches = 0;
$miWon = 0;
$miPoints = 0;
$cskMatches = 0;
$cskWon = 0;
$cskPoints = 0;
$kkrMatches = 0;
$kkrWon = 0;
$kkrPoints = 0;
$ddMatches = 0;
$ddWon = 0;
$ddPoints = 0;


while ($r = mysql_fetch_array($result,MYSQL_ASSOC)) {
  
  $team1 = intval($r["Team1"]);
  $team2 = intval($r["Team2"]);

  if ($team1 == 1 || $team2 == 1)
  {
    $miMatches = $miMatches + 1;
  }
  if ($team1 == 2 || $team2 == 2)
  {
    $cskMatches = $cskMatches + 1;
  }
  if ($team1 == 3 || $team2 == 3)
  {
    $ddMatches = $ddMatches + 1;
  }
  if ($team1 == 5 || $team2 == 5)
  {
    $kkrMatches = $kkrMatches + 1;
  }

  $tmp = $r["Field_First"];
  $fieldfirst = $tmp;

  $firstinn = 0;
  $secinn = 0;
  
  if ($fieldfirst == $team1name) {
    $batfirst = $team2name;
    $batfirstID = $team2;
    $fieldfirstID = $team1;
  }
  else {
    $batfirst = $team1name;
    $batfirstID = $team1;
    $fieldfirstID = $team2;
  }
  $matchID = intval($r["Match_ID"]);

  $query1 = "SELECT SUM(bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) AS Batsman_Runs, 
  SUM(CASE WHEN bt.Dismissal_Type = 'Run-out' THEN 1 ELSE 0 END) AS Run_Outs FROM player_match_batting bt WHERE bt.Team_ID = $batfirstID AND bt.Match_ID = $matchID";

  $res = mysql_query($query1);
  if (!$res) {
    die('Invalid query: ' . mysql_error());
  }
  $batscore1 = 0;
  while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $batscore1 = intval($r["Batsman_Runs"]);
    $runouts1 = intval($r["Run_Outs"]);
  }
  $query2 = "SELECT SUM(bo.No_Balls + bo.Wides + bo.Byes + bo.Leg_Byes + bo.Other_Extras) AS Extras, SUM(bo.Wickets) AS Wickets
  FROM player_match_bowling bo WHERE bo.Team_ID = $fieldfirstID AND bo.Match_ID = $matchID";

  $res = mysql_query($query2);
  if (!$res) {
    die('Invalid query: ' . mysql_error());
  }
  $extras1 = 0;
  while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $extras1 = intval($r["Extras"]);
    $wickets1 = intval($r["Wickets"]) + $runouts1;
  }
  $batfirstScore = $batscore1 + $extras1;

  $query3 = "SELECT SUM(bt.Singles + bt.Doubles*2 + bt.Triples*3 + bt.Fours*4 + bt.Sixes*6) AS Batsman_Runs, 
  SUM(CASE WHEN bt.Dismissal_Type = 'Run-out' THEN 1 ELSE 0 END) AS Run_Outs FROM player_match_batting bt WHERE bt.Team_ID = $fieldfirstID AND bt.Match_ID = $matchID";

  $res = mysql_query($query3);
  if (!$res) {
    die('Invalid query: ' . mysql_error());
  }
  $batscore2 = 0;
  while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $batscore2 = intval($r["Batsman_Runs"]);
    $runouts2 = intval($r["Run_Outs"]);
  }
  $query4 = "SELECT SUM(bo.No_Balls + bo.Wides + bo.Byes + bo.Leg_Byes + bo.Other_Extras) AS Extras, SUM(bo.Wickets) AS Wickets
  FROM player_match_bowling bo WHERE bo.Team_ID = $batfirstID AND bo.Match_ID = $matchID";

  $res = mysql_query($query4);
  if (!$res) {
    die('Invalid query: ' . mysql_error());
  }
  $extras2 = 0;
  while ($r = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $extras2 = intval($r["Extras"]);
    $wickets2 = intval($r["Wickets"]) + $runouts2;
  }
  $batsecScore = $batscore2 + $extras2;

  $wonBy = '';

  if ($batfirstScore > $batsecScore){
    if ($batfirstID == 1)
    {
      $miWon = $miWon + 1;
      $miPoints = $miPoints + 2;
    }
    elseif ($batfirstID == 2)
    {
      $cskWon = $cskWon + 1;
      $cskPoints = $cskPoints + 2;
    }
    elseif ($batfirstID == 3)
    {
      $ddWon = $ddWon + 1;
      $ddPoints = $ddPoints + 2;
    }
    elseif ($batfirstID == 5)
    {
      $kkrWon = $kkrWon + 1;
      $kkrPoints = $kkrPoints + 2;
    }
  }
  elseif ($batfirstScore < $batsecScore){
    if ($fieldfirstID == 1)
    {
      $miWon = $miWon + 1;
      $miPoints = $miPoints + 2;
    }
    elseif ($fieldfirstID == 2)
    {
      $cskWon = $cskWon + 1;
      $cskPoints = $cskPoints + 2;
    }
    elseif ($fieldfirstID == 3)
    {
      $ddWon = $ddWon + 1;
      $ddPoints = $ddPoints + 2;
    }
    elseif ($fieldfirstID == 5)
    {
      $kkrWon = $kkrWon + 1;
      $kkrPoints = $kkrPoints + 2;
    }
  }
 }

echo "<tr>";
echo "<td>Mumbai Indians</td>";
echo "<td>$miMatches</td>";
echo "<td>$miWon</td>";
echo "<td>",$miMatches - $miWon,"</td>";
echo "<td>$miPoints</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Chennai Super Kings</td>";
echo "<td>$cskMatches</td>";
echo "<td>$cskWon</td>";
echo "<td>",$cskMatches - $cskWon,"</td>";
echo "<td>$cskPoints</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Delhi Daredevils</td>";
echo "<td>$ddMatches</td>";
echo "<td>$ddWon</td>";
echo "<td>",$ddMatches - $ddWon,"</td>";
echo "<td>$ddPoints</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Kolkata Knight Riders</td>";
echo "<td>$kkrMatches</td>";
echo "<td>$kkrWon</td>";
echo "<td>",$kkrMatches - $kkrWon,"</td>";
echo "<td>$kkrPoints</td>";
echo "</tr>";
?>
</table>
</div>
</body>
</html>