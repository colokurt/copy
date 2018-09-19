<?php include 'header.php'; ?>  
<?php include 'news.php' ; ?>
<div id="content">
<?php
	try {   
			$db = new PDO('sqlite:../../SharksDB/SharksDB');  
			$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
		} catch (Exception $e) {  
				echo "Error: Could not connect to database.  Please try again later.";
				exit;
			}
		/////////////////////////////////////////////////////////
		////// Getting the season by date or form GET ///////////
		////////////////////////////////////////////////////////	
		
	  $seasonYear = date('Y');
		$checkDate = strtotime(date('m/d/Y'));  //working
		$lowerBound = strtotime("1/1/$seasonYear"); // working       
		$upperBound =  strtotime("10/12/$seasonYear"); // working
	
		if (($checkDate >= $lowerBound) && ($checkDate <= $upperBound)) {	
			$season = date('Y', strtotime('-1 years'));
			$season .= date('Y');
			$seasonEndYear = $seasonYear;

		} else {
			$season = date('Y');
			$season .= date('Y', strtotime('+1 years'));	
			$seasonEndYear = (int)$seasonYear + 1; 
			$seasonEndYear = (string)$seasonEndYear;
		}	

    $dbEntryBound = strtotime("07/01/$seasonEndYear");
		
/* 		echo "season: ". $season. "<br/>";
		echo "seasonYear: " .$seasonYear. "<br />";
		echo "checkDate: ". date('m/d/Y', 1478581200). "<br/>";
		echo "lowerBound: ". date('m/d/Y', 1451624400). "<br/>";  // use var_dump to get date int
    echo "upperBound: ".date('m/d/Y', 1476244800). "<br/>";
		echo "dbEntryBound: ".date('m/d/Y', 1498881600). "<br/>"; */
		
		$year = $_GET['standingsYear'];
		
		/////////////////////////////////////////////////////////
		///////////////// Bind Parameters Function /////////////
		////////////////////////////////////////////////////////
		
		function bindParam($query, $teamid, $confid, $divid, $name, $wins, $losses, $otl, $pts, $gf, $ga, $season) {
			$query->bindParam(':teamid', $teamid);
			$query->bindParam(':confid', $confid);
			$query->bindParam(':divid', $divid);
			$query->bindParam(':name', $name);
			$query->bindParam(':wins', $wins);
			$query->bindParam(':losses', $losses);
			$query->bindParam(':otl', $otl);
			$query->bindParam(':pts', $pts);
			$query->bindParam(':gf', $gf);
			$query->bindParam(':ga', $ga);
			$query->bindParam(':season', $season);
		}
		/////////////////////////////////////////////////////////
		///////////////// Echo Table Functions   ////////////////
		////////////////////////////////////////////////////////
		
		function echoTable($result, $divid) {
			echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td width='15%'>Central</td>";
			echo "<td class='hover'>GP</td>";
			echo "<td class='hover'>Wins</td>";
			echo "<td class='hover'>Losses</td>";
			echo "<td class='hover'>OTL</td>";
			echo "<td class='hover'>Points</td>";
			echo "<td class='hover'>GF</td>";
			echo "<td class='hover'>GA</td>";
			echo "<td class='hover'>+ / -</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
				}
			echo "</table>";
		}
		
		function echoTable1($result, $divid) {
			echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td width='15%'>Atlantic</td>";
			echo "<td class='hover'>GP</td>";
			echo "<td class='hover'>Wins</td>";
			echo "<td class='hover'>Losses</td>";
			echo "<td class='hover'>OTL</td>";
			echo "<td class='hover'>Points</td>";
			echo "<td class='hover'>GF</td>";
			echo "<td class='hover'>GA</td>";
			echo "<td class='hover'>+ / -</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
				}
			echo "</table>";
		}
		
		function echoTable2($result, $divid) {
			echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td width='15%'>Metropolitan</td>";
			echo "<td class='hover'>GP</td>";
			echo "<td class='hover'>Wins</td>";
			echo "<td class='hover'>Losses</td>";
			echo "<td class='hover'>OTL</td>";
			echo "<td class='hover'>Points</td>";
			echo "<td class='hover'>GF</td>";
			echo "<td class='hover'>GA</td>";
			echo "<td class='hover'>+ / -</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
				}
			echo "</table>";
		}
		
		function echoTable3($result, $divid) {
			echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td width='15%'>Wildcard</td>";
			echo "<td class='hover'>GP</td>";
			echo "<td class='hover'>Wins</td>";
			echo "<td class='hover'>Losses</td>";
			echo "<td class='hover'>OTL</td>";
			echo "<td class='hover'>Points</td>";
			echo "<td class='hover'>GF</td>";
			echo "<td class='hover'>GA</td>";
			echo "<td class='hover'>+ / -</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
				}
			echo "</table>";
		}
		
		function echoTable4($result, $divid) {
			echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td width='15%'>Pacific</td>";
			echo "<td class='hover'>GP</td>";
			echo "<td class='hover'>Wins</td>";
			echo "<td class='hover'>Losses</td>";
			echo "<td class='hover'>OTL</td>";
			echo "<td class='hover'>Points</td>";
			echo "<td class='hover'>GF</td>";
			echo "<td class='hover'>GA</td>";
			echo "<td class='hover'>+ / -</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
				}
			echo "</table>";
		}
		
		function echoTable5($result, $divid) {
			echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td width='15%'>Central</td>";
			echo "<td class='hover'>GP</td>";
			echo "<td class='hover'>Wins</td>";
			echo "<td class='hover'>Losses</td>";
			echo "<td class='hover'>OTL</td>";
			echo "<td class='hover'>Points</td>";
			echo "<td class='hover'>GF</td>";
			echo "<td class='hover'>GA</td>";
			echo "<td class='hover'>+ / -</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
				}
			echo "</table>";
		}
				
		function echoTableWC($result) {
			echo "<table class='table sortable'>";					
			foreach ($result as $row) {
				$plusMinus = ($row['gf'] - $row['ga']); 
				$gp = ($row['wins'] + $row['losses'] + $row['otl']);
				echo "<tr>";
					echo "<td width='15%'>";
					echo stripslashes($row['name']);
					echo "</td><td>";
					echo $gp; 						
					echo "</td><td>";
					echo stripslashes($row['wins']);
					echo "</td><td>";	 
					echo stripslashes($row['losses']);  
					echo "</td><td>";	 
					echo stripslashes($row['otl']);	
					echo "</td><td>";	 
					echo stripslashes($row['pts']);
					echo "</td><td>";
					echo stripslashes($row['gf']);
					echo "</td><td>";
					echo stripslashes($row['ga']);
					echo "</td><td>";
					echo $plusMinus;
					echo "</td>";
			 echo "</tr>";
			}
			echo "</table>";
		}
		
		function wildCardQuery($db,$year) {			
		
			/////////////////////////////////////////////////////////
			////////////// Eastern Wildcard Standings ///////////////
			////////////////////////////////////////////////////////	
			
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='1' AND season=:season) AND (seed='1' OR seed='2' OR seed='3'))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();
			echo $divid;
			echo "<h3>Eastern Conference</h3>";
			echoTable1($result);
		
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='1' AND season=:season) AND (seed='4' OR seed='5' OR seed='6'))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();
			echoTable2($result);
			
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='1' AND season=:season) AND (seed='7' OR seed='8'))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();
			echoTable3($result);
			echo "<hr width='85%'/>";
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='1' AND season=:season) AND (seed > 8))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();

			echoTableWC($result);
			
			/////////////////////////////////////////////////////////
			////////////// Western Wildcard Standings ///////////////
			////////////////////////////////////////////////////////
			
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='2' AND season=:season) AND (seed='1' OR seed='2' OR seed='3'))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();
			echo "<h3>Western Conference</h3>";
			echoTable4($result);
							
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='2' AND season=:season) AND (seed='4' OR seed='5' OR seed='6'))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();
			echoTable5($result);
			
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='2' AND season=:season) AND (seed='7' OR seed='8'))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();
			echoTable3($result);
			echo "<hr width='85%'/>";
			$query = $db->prepare("SELECT * FROM standings 
														 WHERE ((confid='2' AND season=:season) AND (seed > 8))
														 ORDER BY seed");
			$query->bindParam(':season', $year);				
			$query->execute();
			$result = $query->fetchAll();

			echoTableWC($result);				
		}
		
		////////////////////////////////////////////////////////
		//// Insert or Update Standings if within bounds ///////
		////////////////////////////////////////////////////////	
		//echo "checkDate: ".$checkDate. " >= ". $upperBound. "<br />";
		//echo "checkDate: ".$checkDate. " < ". $dbEntryBound;
	//	if (($checkDate >= $upperBound) && ($checkDate < $dbEntryBound)) {	
			$xmlDoc = new DOMDocument(); 
			$xmlDoc->load('http://www.tsn.ca/datafiles/XML/NHL/standings.xml'); 
			
			$searchNode = $xmlDoc->getElementsByTagName('wildcards');
			foreach ($searchNode as $node) {
				$conference2 = $node->getElementsByTagName('conference');
				$conference2 = $conference2->item(1)->nodeValue;
			}
			
			$searchNode = $xmlDoc->getElementsByTagName( "team-standing" ); 
			foreach ($searchNode as $searchNode) {
				$teamid = $searchNode->getAttribute('id');
				$name = $searchNode->getAttribute('name');
				$wins = $searchNode->getAttribute('wins');
				$losses = $searchNode->getAttribute('losses');                               
				$otl = $searchNode->getAttribute('overtime');
				$pts = $searchNode->getAttribute('points');
				$gf = $searchNode->getAttribute('goalsFor');
				$ga = $searchNode->getAttribute('goalsAgainst');
				$confid = $searchNode->getAttribute('conf-id');
				$divid = $searchNode->getAttribute('division-id');
				
				$query = $db->prepare("INSERT OR IGNORE INTO standings ('teamid','confid','divid','name','wins','losses','otl','pts','gf','ga','season')
												 VALUES (:teamid, :confid, :divid, :name, :wins, :losses, :otl, :pts, :gf, :ga, :season)");

				bindParam($query, $teamid, $confid, $divid, $name, $wins, $losses, $otl, $pts, $gf, $ga, $season);
				$query->execute();
				
				$query = $db->prepare("Update standings
										 SET teamid=:teamid, confid=:confid, divid=:divid, name=:name, wins=:wins, losses=:losses, otl=:otl, pts=:pts, gf=:gf, ga=:ga, season=:season
										 WHERE teamid=:teamid AND season=:season"); 
						
				bindParam($query, $teamid, $confid, $divid, $name, $wins, $losses, $otl, $pts, $gf, $ga, $season);
				$query->execute();
			}
		  /////////////////////////////////////////////////////////
			///////////////// Getting Wildcard Seed #'s /////////////
			////////////////////////////////////////////////////////
			
			$searchNode = $xmlDoc->getElementsByTagName('wildcards');
			
			foreach ($searchNode as $node) {
				$conference1 = $node->getElementsByTagName('conference');
				$conference1 = $conference1->item(0)->nodeValue;
			}	
			
			$conference1 = preg_replace('/[^0-9,]+/', ",", $conference1);
			$conference1 = substr($conference1, 0, -1); 
			$conference1 = substr($conference1, 1); 
			$conference1Array =  explode(',', $conference1);
			
			$conference1ArrayLength = count($conference1Array);
			
			for ($i = 1; $i <= $conference1ArrayLength; $i++) {
				$wildCardSeed = $i;
				$wildCardID = $conference1Array[$i-1];
				$query = $db->prepare("UPDATE standings 
															 SET  seed=:wildCardSeed
															 WHERE teamid=:wildCardID AND season=:season");
				$query->bindParam(':season', $season);
				$query->bindParam(':wildCardSeed', $wildCardSeed);
				$query->bindParam(':wildCardID', $wildCardID);
				
				$query->execute();
			} 
			$searchNode = $xmlDoc->getElementsByTagName('wildcards');
			
			foreach ($searchNode as $node) {
				$conference2 = $node->getElementsByTagName('conference');
				$conference2 = $conference2->item(1)->nodeValue;
			}
			
			$conference2 = preg_replace('/[^0-9,]+/', ",", $conference2);
			$conference2 = substr($conference2, 0, -1); 
			$conference2 = substr($conference2, 1); 
			$conference2Array =  explode(',', $conference2);
			
			$conference2ArrayLength = count($conference2Array);
			for ($i = 1; $i <= $conference2ArrayLength; $i++) {
				$wildCardSeed = $i;
				$wildCardID = $conference2Array[$i-1];
				
				$query = $db->prepare("UPDATE standings 
															 SET  seed=:wildCardSeed
															 WHERE teamid=:wildCardID AND season=:season");
				$query->bindParam(':season', $season);
				$query->bindParam(':wildCardSeed', $wildCardSeed);
				$query->bindParam(':wildCardID', $wildCardID);
				
				$query->execute();
			} 
	//	}
		
	/////////////////////////////////////////////////////////
	///////////////// Echo HTML Results  ///////////////////
	////////////////////////////////////////////////////////	
	
	echo "<h2>Standings</h3>";
	?>
		<form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" id="search">  
			<select  name="standingsYear" id="standingsYear" class="dropDown" onchange='this.form.submit()'>
				<option <?php if (($_GET['standingsYear'] == '20162017') || !isset($_GET['standingsYear'])) { ?>selected="true" <?php }; ?>value="20162017">2016-2017</option>
				<option <?php if ($_GET['standingsYear'] == '20152016') { ?>selected="true" <?php }; ?>value="20152016">2015-2016</option>
				<option <?php if ($_GET['standingsYear'] == '20142015') { ?>selected="true" <?php }; ?>value="20142015">2014-2015</option>
			</select>
			<select  name="standingsType" id="standingsType" class="dropDown" onchange='this.form.submit()'>
				<option <?php if ($_GET['standingsType'] == 'conference') { ?>selected="true" <?php }; ?> value="conference">Conference</option>
				<option <?php if ($_GET['standingsType'] == 'league') { ?>selected="true" <?php }; ?> value="league">League</option>
				<option <?php if ($_GET['standingsType'] == 'division') { ?>selected="true" <?php }; ?>value="division">Division</option>
				<option <?php if (($_GET['standingsType'] == 'wildcard') || !isset($_GET['standingsType'])) { ?>selected="true" <?php }; ?>value="wildcard">Wildcard</option>
			</select>
		</form>		
	<?php
		
		/////////////////////////////////////////////////////////
		////////////// Default to WildCard Standings ////////////
		////////////////////////////////////////////////////////
		
		if ((isset($_GET['standingsYear'])) && (isset($_GET['standingsType']))) {                 
			$year = $_GET['standingsYear'];
			$standingsType = $_GET['standingsType'];
		} else {
			$year = $season;
			wildCardQuery($db,$year);
		}	
		
		/////////////////////////////////////////////////////////
		////////////// Conference Standings /////////////////////
		////////////////////////////////////////////////////////
		
		if ( $standingsType == 'conference' ) {
			$query = "SELECT * FROM standings WHERE confid='1' and season='$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>Eastern Conference</h3>";
			echoTable($result);
			
			$query = "SELECT * FROM standings WHERE confid='2' AND season='$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>Western Conference</h3>";
			echoTable($result);
		}
		
		/////////////////////////////////////////////////////////
		///////////////// Whole League  ////////////////////////
		////////////////////////////////////////////////////////	
		
		if ( $standingsType == 'league') {
			$query = "SELECT * FROM standings WHERE season='$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>League Standings</h3>";
			echoTable($result);

		}
		
		/////////////////////////////////////////////////////////
		///////////////// By Division  /////////////////////////
		////////////////////////////////////////////////////////	
		
		if ( $standingsType == 'division' ) {
			$query = "SELECT * FROM standings WHERE divid='1' AND season='$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>Atlantic</h3>";
			echoTable($result);
			
			$query = "SELECT * FROM standings WHERE divid='2' AND season = '$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>Metropolitan</h3>";
			echoTable($result);
			
			$query = "SELECT * FROM standings WHERE divid='3' AND season='$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>Central</h3>";
			echoTable($result);
			
			$query = "SELECT * FROM standings WHERE divid='4' AND season='$year' ORDER BY pts DESC";
			$result = $db->query($query);
			echo "<h3>Pacific</h3>";
			echoTable($result);
		}
		
		if (($standingsType == 'wildcard') && ($year == '20162017')) {
			wildCardQuery($db,$year);
		} 
		else  if (($standingsType == 'wildcard') && (($year == '20142015') || ($year == '20152016')))  {
			echo "There is no data here, sorry....";
		}
				
?>
</div>
  <?php include 'pictures.php' ; ?> 
	<?php include 'footer.php' ; ?>
</div> 
</html>