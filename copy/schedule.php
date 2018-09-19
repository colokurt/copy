<?php include 'header.php'; ?>  
	<div id="container">
	<?php include 'news.php' ; ?>
		<div id="content">
			<?php
			
			$seasonYear = date('Y');
			$checkDate = date('m/d/Y');
			$checkDate=date('m/d/Y', strtotime($checkDate));
			$lowerBound = date('m/d/Y', strtotime("01/01/$seasonYear"));
			$upperBound = date('m/d/Y', strtotime("10/01/$seasonYear"));
			$endOfSeason = date('m/d/Y', strtotime("07/01/$seasonYear"));

			if (($checkDate >= $lowerBound) && ($checkDate < $upperBound)) {	
				$season = date('Y', strtotime('-1 years'));
				$season .= date('Y');
			} else {
				$season = date('Y');
				$season .= date('Y', strtotime('+1 years'));	
			}
						
			if (($checkDate >= $upperBound) && ($checkDate <= $endOfSeason)) {
			  $date = strtotime("now");
				$json = file_get_contents('http://live.nhl.com/GameData/SeasonSchedule-'.$season.'.json');
				$json = json_decode($json, TRUE);

				foreach($json as $d) {
					 $idGame = $d['id'];
					 $estTime = $d['est'];
					 $home = $d['h'];
					 $away = $d['a'];
					 $year = (int)substr($estTime, 0, 4);
					 $month = (int)substr($estTime, 4, -11);
					 $day = (int)substr($estTime, 6, -9);
					 $time = (int)substr($estTime, 9, -3);
					 $hour = (int)substr($estTime, 9, -6);
					 $minute = (int)substr($estTime, 12, -3);
						
					$query =	$db->prepare("INSERT or IGNORE INTO schedule ( id, day, month, year, hour, minute, home, away, season)
																	VALUES (:idGame, :day, :month, :year, :hour, :minute, :home, :away, :season)");
					
					$query->bindParam(':idGame', $idGame);
					$query->bindParam(':day', $day);
					$query->bindParam(':month', $month);
					$query->bindParam(':year', $year);
					$query->bindParam(':hour', $hour);
					$query->bindParam(':minute', $minute);
					$query->bindParam(':home', $home);
					$query->bindParam(':away', $away);
					$query->bindParam(':season', $season);
					
					$query->execute(); 
				}
			}	
				echo "<h2>Schedule and Results</h2>";
			?>
			<form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" id="search">
				<select name='resultsYear' id='resultsYear' class='dropDown' onchange='this.form.submit()'>
					<option <?php if (($_GET['resultsYear'] == '20162017') || !isset($_GET['resultsYear'])) { ?>selected="true" <?php }; ?>value="20162017">2016-2017</option>
					<option <?php if ($_GET['resultsYear'] == '20152016') { ?>selected="true" <?php }; ?>value="20152016">2015-2016</option>
					<option <?php if ($_GET['resultsYear'] == '20142015') { ?>selected="true" <?php }; ?>value="20142015">2014-2015</option>
					<option <?php if ($_GET['resultsYear'] == '20132014') { ?>selected="true" <?php }; ?>value="20132014">2013-2014</option>
					<option <?php if ($_GET['resultsYear'] == '20122013') { ?>selected="true" <?php }; ?>value="20122013">2012-2013</option>
				</select>
				<select name='resultsTeam' id='resultsTeam' class='dropDown' onchange='this.form.submit()'>
					<option <?php if ($_GET['resultsTeam'] == 'ANA') { ?>selected="true" <?php }; ?>value="ANA">Anaheim</option>
					<option <?php if ($_GET['resultsTeam'] == 'ARI') { ?>selected="true" <?php }; ?>value="ARI">Arizona</option>
					<option <?php if ($_GET['resultsTeam'] == 'BOS') { ?>selected="true" <?php }; ?>value="BOS">Boston</option>
					<option <?php if ($_GET['resultsTeam'] == 'BUF') { ?>selected="true" <?php }; ?>value="BUF">Buffalo</option>
					<option <?php if ($_GET['resultsTeam'] == 'CAR') { ?>selected="true" <?php }; ?>value="CAR">Carolina</option>
					<option <?php if ($_GET['resultsTeam'] == 'CBJ') { ?>selected="true" <?php }; ?>value="CBJ">Columbus</option>
					<option <?php if ($_GET['resultsTeam'] == 'CGY') { ?>selected="true" <?php }; ?>value="CGY">Calgary</option>
					<option <?php if ($_GET['resultsTeam'] == 'CHI') { ?>selected="true" <?php }; ?>value="CHI">Chicago</option>
					<option <?php if ($_GET['resultsTeam'] == 'COL') { ?>selected="true" <?php }; ?>value="COL">Colorado</option>
					<option <?php if ($_GET['resultsTeam'] == 'DAL') { ?>selected="true" <?php }; ?>value="DAL">Dallas</option>
					<option <?php if ($_GET['resultsTeam'] == 'DET') { ?>selected="true" <?php }; ?>value="DET">Detroit</option>
					<option <?php if ($_GET['resultsTeam'] == 'EDM') { ?>selected="true" <?php }; ?>value="EDM">Edmonton</option>
					<option <?php if ($_GET['resultsTeam'] == 'FLA') { ?>selected="true" <?php }; ?>value="FLA">Florida</option>
					<option <?php if ($_GET['resultsTeam'] == 'LAK') { ?>selected="true" <?php }; ?>value="LAK">Los Angeles</option>
					<option <?php if ($_GET['resultsTeam'] == 'MIN') { ?>selected="true" <?php }; ?>value="MIN">Minnesota</option>
					<option <?php if ($_GET['resultsTeam'] == 'MTL') { ?>selected="true" <?php }; ?>value="MTL">Montreal</option>
					<option <?php if ($_GET['resultsTeam'] == 'NJD') { ?>selected="true" <?php }; ?>value="NJD">New Jersey</option>
					<option <?php if ($_GET['resultsTeam'] == 'NSH') { ?>selected="true" <?php }; ?>value="NSH">Nashville</option>
					<option <?php if ($_GET['resultsTeam'] == 'NYI') { ?>selected="true" <?php }; ?>value="NYI">NYI</option>
					<option <?php if ($_GET['resultsTeam'] == 'NYR') { ?>selected="true" <?php }; ?>value="NYR">NYR</option>
					<option <?php if ($_GET['resultsTeam'] == 'OTT') { ?>selected="true" <?php }; ?>value="OTT">Ottawa</option>
					<option <?php if ($_GET['resultsTeam'] == 'PHI') { ?>selected="true" <?php }; ?>value="PHI">Philadelphia</option>
					<option <?php if ($_GET['resultsTeam'] == 'PIT') { ?>selected="true" <?php }; ?>value="PIT">Pittsburgh</option>
					<option <?php if (($_GET['resultsTeam'] == 'SJS') || !isset($_GET['resultsTeam'])) { ?>selected="true" <?php }; ?>value="SJS">San Jose</option>
					<option <?php if ($_GET['resultsTeam'] == 'STL') { ?>selected="true" <?php }; ?>value="STL">St Louis</option>
					<option <?php if ($_GET['resultsTeam'] == 'TBL') { ?>selected="true" <?php }; ?>value="TBL">Tampa Bay</option>
					<option <?php if ($_GET['resultsTeam'] == 'TOR') { ?>selected="true" <?php }; ?>value="TOR">Toronto</option>
					<option <?php if ($_GET['resultsTeam'] == 'VAN') { ?>selected="true" <?php }; ?>value="VAN">Vancouver</option>
					<option <?php if ($_GET['resultsTeam'] == 'WPG') { ?>selected="true" <?php }; ?>value="WPG">Winnipeg</option>
					<option <?php if ($_GET['resultsTeam'] == 'WSH') { ?>selected="true" <?php }; ?>value="WSH">Washington</option>
				</select>
			</form>
			<?php
				
	if ((isset($_GET['resultsYear'])) &&  (isset($_GET['resultsTeam']))) {                 
		$season = $_GET['resultsYear'];
		$team = $_GET['resultsTeam'];
		$query1 = "SELECT schedule.id, results.id, ata, atc, atcommon, atn, ats, atsog, hta, htc, htcommon, htn, hts, htsog, bs, bsc, home, away, schedule.season, year, month, day, hour - 12 AS adjustedHour, 
		CASE WHEN minute = 0 THEN '00' 
		ELSE 30
		END
		minute
		FROM schedule
		JOIN results
		On schedule.id = results.id
		WHERE ((home='$team' AND schedule.season= $season) OR (away='$team' AND schedule.season= $season))";
		
		$result1 = $db->query($query1);
		
		echo "<table class='table'>";	
		echo "<tr class='TableHeaders'>";
		echo "<td class='' width='13%'>Date</td>";
		echo "<td class='' width='9%'>Time</td>";	
		echo "<td class=''>Home</td>";
		echo "<td class='' width='7%'></td>";
		echo "<td colspan='3' width='10%' class=''>Score</td>";
		echo "<td class='' width='7%'></td>";
		echo "<td class=''>Away</td>";
		echo "<td class=''width='10%'>Record</td>";	
		echo "<td class=''width='9%'>Status</td>";				
		echo "</tr>";	
		$index = 0;
		$wins = 0;
		$losses = 0;
		$otl = 0;
		foreach ($result1 as $index => $row) {
			$index++;
			$gameMonth = $row['month'];			
			$gameDay = $row['day'];
			$gameYear = $row['year'];
			$gameDate = $gameMonth."/".$gameDay."/".$gameYear;
			$gameDate = strtotime($gameDate);
			$htn = $row['htn'];
			$atn = $row['atn'];
			$ata = $row['ata'];
			$hta = $row['hta'];
			
			$query2 = "SELECT logo FROM teams WHERE UPPER(team_name) = (UPPER('$htn'))";
			$result2 = $db->query($query2);
			foreach ($result2 as $row2) {
				$logoHome = $row2['logo'];
			}
			
			$query3 = "SELECT logo FROM teams WHERE UPPER(team_name) = (UPPER('$atn'))";
			$result3 = $db->query($query3);
			foreach ($result3 as $row3) {
				$logoAway = $row3['logo'];
			}
			
			if  (($index == 83) || (($index == 49) && ($year == "20122013"))) {
				echo "</table>";
				echo "<h3> Playoff Results </h3>";
				echo "<table class='table'>";	
				echo "<tr class='TableHeaders'>";
				echo "<td class='' width='13%'>Date</td>";
				echo "<td class='' width='9%'>Time</td>";	
				echo "<td class=''>Home</td>";
				echo "<td class='' width='7%'></td>";
				echo "<td colspan='3' width='10%' class=''>Score</td>";
				echo "<td class='' width='7%'></td>";
				echo "<td class=''>Away</td>";
				echo "<td class='' width='10%'>Record</td>";	
				echo "<td class='' width='9%'>Status</td>";				
				echo "</tr>";	
			} 
			
			echo "<tr>";
				echo "<td>";
				echo stripslashes($row['month'])."/".stripslashes($row['day'])."/".stripslashes($row['year']); 
				echo "</td><td>";	 
				echo stripslashes($row['adjustedHour']).":".stripslashes($row['minute'])." PM";
				echo "</td><td>";
				echo stripslashes($row['htn']);					
				echo "</td><td>";
				echo "<img src='$logoHome' height='40px'>";		
				echo "</td><td>";	
				echo stripslashes($row['hts']);	
				echo "</td>";
				
			if ((($row['ata'] == "$team" ) && ($row['ats'] > $row['hts']))  ||  (($row['hta'] == "$team" ) && ($row['hts'] > $row['ats']))) {      // this will give us a win or loss based on scores
				echo "<td class ='winCSS'> W";
			} else if ((($row['ata'] == "$team" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "$team" ) && ($row['hts'] < $row['ats']))) {
					echo "<td class ='lossCSS'> L";
				} else {
						echo "<td>TBD";
					}
				
				echo "</td><td>";
				echo stripslashes($row['ats']);
				echo "</td><td>";	
				echo "<img src='$logoAway' height='40px'>";
				echo "</td><td>";
				echo stripslashes($row['atn']);					
				echo "</td><td>";
								
			if (((($row['bs'] == "FINAL") || ($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
			&& ((($row['ata'] == "$team" ) && ($row['ats'] > $row['hts']))  ||  (($row['hta'] == "$team" ) 
			&& ($row['hts'] > $row['ats'])))) && ($index != 83)) {
				$wins++;
			} else if ((($row['bs'] == "FINAL") && ((($row['ata'] == "$team" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "$team" ) && ($row['hts'] < $row['ats'])))) && ($index != 83)) {
				$losses++;
			} else if (((($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
			&& ((($row['ata'] == "$team" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "$team" ) 
			&& ($row['hts'] < $row['ats'])))) && ($index != 83)) {
				$otl++;
			
			// reset scores at game 82 or 49 if the season is 2012-2013
			
			} else if ((($row['bs'] == "FINAL") || ($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
				   && ((($row['ata'] == "$team" ) && ($row['ats'] > $row['hts']))  ||  (($row['hta'] == "$team" ) && ($row['hts'] > $row['ats']))) 
				   && (($index = 83) || (($index = 49) && ($year == "20122013")))) {
				$wins = 0;
				$losses = 0;
				$otl = 0;
				$wins ++;
			}	else if (((($row['bs'] == "FINAL") || ($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO")) 
			         && ((($row['ata'] == "$team" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "$team" ) && ($row['hts'] < $row['ats'])))) 
					 && ($index = 83) || (($index = 49) && ($year == "20122013"))) {
				$wins = 0;
				$losses = 0;
				$otl = 0;
				$losses ++;
			} else if ((($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
			       && ((($row['ata'] == "$team" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "$team" ) && ($row['hts'] < $row['ats'])))
				   && (($index = 83) || (($index = 49) && ($year == "20122013")))) {
				$wins = 0;
				$losses = 0;
				$otl = 0;
				$otl++;
			}
				
				echo $wins." - ".$losses." - ".$otl;
				echo "</td><td>";
				echo $row['bs'];
				echo "</td>";
				echo "</tr>";
		}
		echo "</table>";
	} else {

		$query = "SELECT schedule.id, results.id, ata, atc, atcommon, atn, ats, atsog, hta, htc, htcommon, htn, hts, htsog, bs, bsc, home, away, schedule.season, year, month, day, hour - 12 AS adjustedHour, 
		CASE WHEN minute = 0 THEN '00' 
		ELSE 30
		END
		minute
		FROM schedule
		JOIN results
		On schedule.id = results.id
		WHERE ((home='SJS' AND schedule.season= $season) OR (away='SJS' AND schedule.season= $season))";
		
		$result = $db->query($query);
		echo "<table class='table'>";	
		echo "<tr class='TableHeaders'>";
		echo "<td class='' width='13%'>Date</td>";
		echo "<td class='' width='9%'>Time</td>";	
		echo "<td class=''>Home</td>";
		echo "<td class='' width='7%'></td>";
		echo "<td colspan='3' width='10%' class=''>Score</td>";
		echo "<td class='' width='7%'></td>";
		echo "<td class=''>Away</td>";
		echo "<td class='' width='10%'>Record</td>";	
		echo "<td class='' width='9%'>Status</td>";				
		echo "</tr>";	
		$index = 0;
		$wins = 0;
		$losses = 0;
		$otl = 0;
		foreach ($result as $index => $row) {
			$index++;
			$gameMonth = $row['month'];			
			$gameDay = $row['day'];
			$gameYear = $row['year'];
			$gameDate = $gameMonth."/".$gameDay."/".$gameYear;
			$gameDate = strtotime($gameDate);
			$htn = $row['htn'];
			$atn = $row['atn'];
			$hta = $row['hta'];
			$ata = $row['ata'];


			$query2 = "SELECT logo FROM teams WHERE UPPER(team_name) = (UPPER('$htn'))";
			$result2 = $db->query($query2);
			foreach ($result2 as $row2) {
				$logoHome = $row2['logo'];
			}
			
			$query3 = "SELECT logo FROM teams WHERE UPPER(team_name) = (UPPER('$atn'))";
			$result3 = $db->query($query3);
			foreach ($result3 as $row3) {
				$logoAway = $row3['logo'];
			}
    if (($index == 83) || (($index == 49) && ($year == "20122013"))) {
			echo "</table>";
			echo "<h2> Playoff Results </h2>";
			echo "<table class='table'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td class='' width='13%'>Date</td>";
			echo "<td class='' width='9%'>Time</td>";	
			echo "<td class=''>Home</td>";
			echo "<td class='' width='7%'></td>";
			echo "<td colspan='3' width='10%' class=''>Score</td>";
			echo "<td class='' width='7%'></td>";
			echo "<td class=''>Away</td>";
			echo "<td class='' width='10%'>Record</td>";	
			echo "<td class='' width='9%'>Status</td>";				
			echo "</tr>";	
		} 
						
		echo "<tr>";
				echo "<td>";
				echo stripslashes($row['month'])."/".stripslashes($row['day'])."/".stripslashes($row['year']);
				echo "</td><td>";						
				echo stripslashes($row['adjustedHour']).":".stripslashes($row['minute'])." PM";
				echo "</td><td>";	 
				echo stripslashes($row['htn']);					
				echo "</td><td>";	 
				echo "<img src='$logoHome' height='40px'>";		
				echo "</td><td>";
				echo stripslashes($row['hts']);	
				echo "</td>";

			if ((($row['ata'] == "SJS" ) && ($row['ats'] > $row['hts']))  ||  (($row['hta'] == "SJS" ) && ($row['hts'] > $row['ats']))) {      // this will give us a win or loss based on scores
				echo "<td class ='winCSS'> W";
			} else if ((($row['ata'] == "SJS" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "SJS" ) && ($row['hts'] < $row['ats']))) {
					echo "<td class ='lossCSS'> L";
				} else {
						echo "<td>TBD";
					}
				
				echo "</td><td>";
				echo stripslashes($row['ats']);
				echo "</td><td>";
				echo "<img src='$logoAway' height='40px'>";	
				echo "</td><td>";
				echo stripslashes($row['atn']);
				echo "</td><td>";
				
			if (((($row['bs'] == "FINAL") || ($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
			&& ((($row['ata'] == "SJS" ) && ($row['ats'] > $row['hts']))  ||  (($row['hta'] == "SJS" ) 
			&& ($row['hts'] > $row['ats'])))) && ($index != 83)) {
				$wins++;
			} else if ((($row['bs'] == "FINAL") && ((($row['ata'] == "SJS" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "SJS" ) && ($row['hts'] < $row['ats'])))) && ($index != 83)) {
				$losses++;
			} else if (((($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
			&& ((($row['ata'] == "SJS" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "SJS" ) 
			&& ($row['hts'] < $row['ats'])))) && ($index != 83)) {
				$otl++;
			
			// reset scores at game 89 or 49 if the season is 2012-2013
			
			} else if ((($row['bs'] == "FINAL") || ($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
				   && ((($row['ata'] == "SJS" ) && ($row['ats'] > $row['hts']))  ||  (($row['hta'] == "SJS" ) && ($row['hts'] > $row['ats']))) 
				   && (($index = 83) || (($index = 49) && ($year == "20122013")))) {
				$wins = 0;
				$losses = 0;
				$otl = 0;
				$wins ++;
			}	else if (((($row['bs'] == "FINAL") || ($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO")) 
			         && ((($row['ata'] == "SJS" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "SJS" ) && ($row['hts'] < $row['ats'])))) 
					 && ($index = 83) || (($index = 49) && ($year == "20122013"))) {
				$wins = 0;
				$losses = 0;
				$otl = 0;
				$losses ++;
			} else if ((($row['bs'] == "FINAL OT") || ($row['bs'] == "FINAL SO") || ($row['bs'] == "FINAL 2OT") || ($row['bs'] == "FINAL 3OT")) 
			       && ((($row['ata'] == "SJS" ) && ($row['ats'] < $row['hts']))  ||  (($row['hta'] == "SJS" ) && ($row['hts'] < $row['ats'])))
				   && (($index = 83) || (($index = 49) && ($year == "20122013")))) {
				$wins = 0;
				$losses = 0;
				$otl = 0;
				$otl++;
			}
				
				echo $wins." - ".$losses." - ".$otl;
				echo "</td><td>";
				echo $row['bs'];
				echo "</td>";
				echo "</tr>";
		}
		echo "</table>";
	}
				?>
		</div>		
		<?php include 'pictures.php' ; ?>
	<?php include 'footer.php' ; ?>
	</div>
	</div>  
</html>