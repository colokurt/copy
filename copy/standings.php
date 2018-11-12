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

		$url = "https://colokurt:Sunset48!@api.mysportsfeeds.com/v1.2/pull/nhl/2018-2019-regular/playoff_team_standings.json";
		$json = file_get_contents($url);
		$json = json_decode($json);
		echo "<h3>Conference Playoff Standings 2018-2019</h3>";
		for($i=0; $i<count($json->playoffteamstandings->conference); $i++)  {
				$conference = $json->playoffteamstandings->conference[$i]->{'@name'};
							echo "<table class='table sortable'>";	
							echo "<tr class='TableHeaders'>";
							echo "<td class='hover'>Rank</td>";
							echo "<td width='15%'>$conference</td>";
							echo "<td class='hover'>GP</td>";
							echo "<td class='hover'>Wins</td>";
							echo "<td class='hover'>Losses</td>";
							echo "<td class='hover'>OTL</td>";
							echo "<td class='hover'>Points</td>";
							echo "<td class='hover'>GF</td>";
							echo "<td class='hover'>GA</td>";
							echo "<td class='hover'>+ / -</td>";
							echo "</tr>";	
			for($j=0; $j<count($json->playoffteamstandings->conference[$i]->teamentry); $j++)  {	
				$id = $json->playoffteamstandings->conference[$i]->teamentry[$j]->team->ID;
				$city = $json->playoffteamstandings->conference[$i]->teamentry[$j]->team->City;
				$name = $json->playoffteamstandings->conference[$i]->teamentry[$j]->team->Name;
				$abbrev = $json->playoffteamstandings->conference[$i]->teamentry[$j]->team->Abbreviation;
				
				$rank = $json->playoffteamstandings->conference[$i]->teamentry[$j]->rank;
				$gamesPlayed = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->GamesPlayed->{'#text'};
				$wins = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->Wins->{'#text'};
				$losses = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->Losses->{'#text'};
				$otw = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->OvertimeWins->{'#text'};
				$otl = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->OvertimeLosses->{'#text'};
			  $gf = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->GoalsFor->{'#text'};
				$ga = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->GoalsAgainst->{'#text'};
				$pts = $json->playoffteamstandings->conference[$i]->teamentry[$j]->stats->stats->Points->{'#text'};
				$pm = $gf - $ga;
				
								echo "<tr>";
								echo "<td>$rank</td>";
								echo "<td>$city</td>";
								echo "<td>$gamesPlayed</td>";
								echo "<td>$wins</td>";
								echo "<td>$losses</td>";
								echo "<td>$otl</td>";
								echo "<td>$pts</td>";
								echo "<td>$gf</td>";
								echo "<td>$ga</td>";
								echo "<td>$pm</td>";
								echo "</tr>";

			}
			echo "</table>";
		}
		?>
</div>
  <?php include 'pictures.php' ; ?> 
	<?php include 'footer.php' ; ?>		
</div>
</html>