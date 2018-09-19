<!DOCTYPE html >
<?php
//error_reporting(E_ERROR);
//ini_set('display_errors', 1); 
?>
<html>
<head>
  <meta charset="utf-8" >
	<title>SJS</title>
  <link rel="stylesheet" type="text/css" href="sharkscss.css"> 
	<link rel="icon" href="images/favicon.ico">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="scripts.js"></script>
</head>
<div id='fixedHeader'>
	<table  class="upper-nav">
			<tr>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='index.php';">HOME</button>
					</div>
				</th>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='schedule.php';">SCHEDULE</button>
					</div>
				</th>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='roster.php';">ROSTER</button>
					</div>
				</th>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='statistics.php';" >STATISTICS</button>
						<div class="dropdown-content">
							<a href="statistics.php">Individual Stats</a>
							<a href="leaders.php">League Leaders</a>
						</div>
					</div>
				</th>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='standings.php';">STANDINGS</button>
						<div class="dropdown-content">
							<a href="standings.php?standingsYear=20162017&standingsType=league">League</a>
							<a href="standings.php?standingsYear=20162017&standingsType=conference">Conference</a>
							<a href="standings.php?standingsYear=20162017&standingsType=division">Division</a>
							<a href="standings.php?standingsYear=20162017&standingsType=wildcard">Wildcard</a>
						</div>
					</div>
				</th>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='cms';">FORUM</button>
					</div>
				</th>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='results.php';">HISTORY</button>
					</div>
				</th>
			</tr>
	</table>
</div>
<div id='fixedHeader_mobile'>
	<table  class="upper-nav">
			<tr>
				<th width="15%">	
					<div class="dropdown">
						<button class="dropbtn" onclick="location.href='standings.php';">MENU</button>
						<div class="dropdown-content">
							<a href="index.php">HOME</a>
							<a href="schedule.php">SCHEDULE</a>
							<a href="roster.php">ROSTER</a>
							<a href="statistics.php">STATISTICS</a>
							<a href="leaders.php">LEADERS</a>
							<a href="standings.php">STANDINGS</a>
							<a href="results.php">HISTORY</a>
							<a href="archive.php">NEWS</a>
							<a href="cms">FORUM</a>
						</div>
					</div>
				</th>
			</tr>
	</table>
</div>
<div id='wrapper'>
	<div id="ajaxScores">
		<?php include 'get_scores.php'; ?>  
	</div> 
	<h1>San Jose Shark Tank</h1>
<?php
	$time=date("m/d/y"); // date and time in a single variable
	 if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
			$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	try {
		$query = $db->prepare("INSERT INTO unique_ip ('ip', 'timestamp') VALUES (:ip, :time)"); 
		$query->bindParam(':ip', $ip);
		$query->bindParam(':time', $time);
	
		$query->execute();
	} catch (Exception $e) {
		exit;
	}
		if (!$db->errno == 1062) {
	}
?>