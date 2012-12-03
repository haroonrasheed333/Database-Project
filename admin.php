<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>IPL 2012</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link href='http://fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
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
                <li><a href="stats.php">Stats</a></li>
                <li class="active"><a href="admin.php">Admin</a></li>
            </ul>
      </div>
		</div>
        <h2 class="collapse">+ Add a new Player</h2>
        
        <form id="addPlayer" class="content" method="post" accept-charset="utf-8">
            <div class="formDiv">   
                <label for="player-name">Player Name</label>
                <input type="text" name="player-name">
            </div>
            <div class="formDiv">
                <label for="team-id">Team</label>
                <select name="team-name">
                    <option value="1">Mumbai Indians</option>
                    <option value="2">Chennai Super Kings</option>
                    <option value="3">Delhi Daredevils</option>
                    <option value="4">Kings XI Punjab</option>
                    <option value="5">Kolkata Knight Riders</option>
                    <option value="6">Pune Warriors India</option>
                    <option value="7">Rajasthan Royals</option>
                    <option value="8">RCB</option>
                </select>
            </div>
            <div class="formDiv">
                <label for="dob">DOB </label>
                <input id="datepicker" type="text" name="dob">
            </div>
            <br>
            <div class="formDiv">
                <label for="nick">Nick Name </label>
                <input type="text" name="nick"/>
            </div>
            <div class="formDiv">
                <label for="previous">Previous Team </label>
                <select name="prev-team">
                    <option value="1">Mumbai Indians</option>
                    <option value="2">Chennai Super Kings</option>
                    <option value="3">Delhi Daredevils</option>
                    <option value="4">Kings XI Punjab</option>
                    <option value="5">Kolkata Knight Riders</option>
                    <option value="6">Pune Warriors India</option>
                    <option value="7">Rajasthan Royals</option>
                    <option value="8">RCB</option>
                </select>
            </div>
            <div class="formDiv">
                <label for="matches">Matches </label>
                <input type="text" name="matches">
            </div>
            <br>
            <div class="formDiv">
                <label for="batting">Batting Style </label>
                <select name="batting">
                    <option value="Right-handed">Right Hand Batsman</option>
                    <option value="Left-handed">Left Hand Batsman</option>
                </select>
            </div>
            <div class="formDiv">
                <label for="bowling">Bowling Style </label>
                <select name="bowling">
                    <option value="Right-arm off break">Right-arm off break</option>
                    <option value="Right-arm medium">Right-arm medium</option>
                    <option value="Right arm medium-fast">Right arm medium-fast</option>
                    <option value="Right-arm fast">Right-arm fast</option>
                    <option value="Right-arm leg break">Right-arm leg break</option>
                    <option value="Left-arm off break">Left-arm off break</option>
                    <option value="Left-arm medium">Left-arm medium</option>
                    <option value="Left arm medium-fast">Left arm medium-fast</option>
                    <option value="Left-arm fast">Left-arm fast</option>
                    <option value="Left-arm leg break">Left-arm leg break</option>
                </select>
            </div>
            <div class="formDiv">
                <label for="role">Playing Role </label>
                <input type="text" name="role"/>
            </div>
            <br>
            <div class="formDiv">
                <label for="mom">MOM </label>
                <input type="text" name="mom"/>
            </div>
            <br>
            <br>
            <p><input type="submit" class="btn" name= "submit-player" value="Submit"></p>
        </form>
        <br>

        <h2 class="collapse">+ Add a new Team</h2>

		<form id="addTeam" class="content" method="post" accept-charset="utf-8">
            <div class="formDiv">
                <label for="team-name">Team Name</label>
                <input type="text" name="team-name">
            </div>
            <div class="formDiv">
                <label for="owner">Owner </label>
                <input type="text" name="owner">
            </div>
            <div class="formDiv">
                <label for="coach">Coach </label>
                <input type="text"name="coach">
            </div>
            <div class="formDiv">
                <label for="captain">Captain </label>
                <input type="text" name="captain"/>
            </div>
            <br>
            <div class="formDiv">
                <label for="best">Best Finish </label>
                <input type="text" name="best">
            </div>
            <div class="formDiv">
                <label for="lowest">Lowest </label>
                <input type="text"name="lowest">
            </div>
            <div class="formDiv">
                <label for="net">Net Worth </label>
                <input type="text" name="net"/>
            </div>

                <br>
                <br>
                <h2>Home Venue Details</h2>
            <div class="formDiv">
                <label for="venue">Venue Name </label>
                <input type="text" name="venue"/>
            </div>
            <div class="formDiv">
                <label for="capacity">Capacity </label>
                <input type="text" name="capacity"/>
            </div>
            <br>
            <br>
            <p><input type="submit" class="btn" name= "submit-team" value="Submit"></p>
        </form>

        <?php

        if (!empty($_POST['submit-player'])) {
        	$name = $_POST["player-name"];
            $team = intval($_POST["team-name"]);
            $dob = $_POST["dob"];
            $dob = date("Y-m-d", strtotime($dob));
            $nick = $_POST["nick"];
            $previous = intval($_POST["prev-team"]);
            $matches = $_POST["matches"];
            $batting = $_POST["batting"];
            $bowling = $_POST["bowling"];
            $role = $_POST["role"];
            $mom = intval($_POST["mom"]);



            mysql_connect("127.0.0.1","root","") or die("Could not connect: " . mysql_error());
            mysql_select_db("haroon");

            $res = mysql_query("SELECT MAX(Player_ID) AS Max FROM players");

            $pid = 0;
            while ($r = mysql_fetch_array($res,MYSQL_ASSOC)) {
                $tmp = intval($r["Max"]);
                $pid = $tmp + 1;
            }

        	$query = "INSERT INTO `Players`(`Player_ID`, `Team_ID`, `Player_Name`, `DOB`, `Nick_Name`, `Previous_Team`, 
                `Batting_Style`, `Bowling_Style`, `Playing_Role`, `MOM`, `Matches`) 
             VALUES ($pid,$team,'$name','$dob','$nick','$previous','$batting','$bowling','$role','$mom','$matches')";

        	$result = mysql_query($query);
        	if (!$result) {
                die('Invalid query: ' . mysql_error());
        	}
        }

        ?>

        <?php

        if (!empty($_POST['submit-team'])) {
        	$team = $_POST["team-name"];
            $owner = $_POST["owner"];
            $coach = $_POST["coach"];
            $captain = $_POST["captain"];
            $venue = $_POST["venue"];
            $best = intval($_POST["best"]);
            $lowest = intval($_POST["lowest"]);
            $net = intval($_POST["net"]);
            $venue = $_POST["venue"];
            $capacity = $_POST["capacity"];

            mysql_connect("127.0.0.1","root","") or die("Could not connect: " . mysql_error());
            mysql_select_db("haroon");

            $res = mysql_query("SELECT MAX(Venue_ID) AS Max FROM venues");

            $vid = 0;
            while ($r = mysql_fetch_array($res,MYSQL_ASSOC)) {
                $tmp = intval($r["Max"]);
                $vid = $tmp + 1;
            }
            
        	$query = "INSERT INTO `Venues`(`Venue_ID`, `Venue_Name`, `Capacity`) 
            VALUES ('$vid','$venue','$capacity')";
        	$result = mysql_query($query);
        	 if (!$result) {
           	die('Invalid query: ' . mysql_error());
        	}

            $res1 = mysql_query("SELECT MAX(Team_ID) AS Max FROM teams");

            $tid = 0;
            while ($r = mysql_fetch_array($res1,MYSQL_ASSOC)) {
                $tmp = intval($r["Max"]);
                $tid = $tmp + 1;
            }

        	 $query1 = "INSERT INTO `Teams`(`Team_ID`, `Team_Name`, `Owner`, `Coach`, `Captain`,
              `Best_Finish`, `Lowest_Finish`, `Net_Worth`, `Venue_ID`) 
                VALUES ('$tid','$team','$owner','$coach','$captain','$best','$lowest','$net', '$vid')";

        	 $result1 = mysql_query($query1);
        	 if (!$result1) {
           	die('Invalid query: ' . mysql_error());
        	}
        }

        ?>
    </div>
</body>
</html>

