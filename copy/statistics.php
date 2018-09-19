<?php include 'header.php'; ?>  
	<div id="wrapper">
	<div id="container">
<?php include 'news.php' ; ?>
	<div id="content">
	<h2> Player Statistics</h2>
<?php
try {   
	$db = new PDO('sqlite:../../SharksDB/SharksDB');  
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
} catch (Exception $e) {  
	 echo "Error: Could not connect to database.  Please try again later.";
	 exit;
}	
function echoTable($result) {
	echo "<table class='table sortable'>";	
			echo "<tr class='TableHeaders'>";
			echo "<td class='hover' width='5%'>#</td>";
			echo "<td class='hover' width='10%'>Pos</td>";
			echo "<td class='hover'>Name</td>";
			echo "<td class='hover' width='5%'>GP</td>";
			echo "<td class='hover' width='10%'>G</td>";
			echo "<td class='hover' width='10%'>A</td>";
			echo "<td class='hover' width='10%'>Pts</td>";
			echo "<td class='hover' width='10%'>PIM</td>";
			echo "<td class='hover' width='10%'>+/-</td>";
			echo "</tr>";	
			
			foreach ($result as $row) {
				echo "<tr>";
					echo "<td>";
					echo stripslashes($row['jerseynumber']); 
					echo "</td><td>";
					echo stripslashes($row['position']);
					echo "</td><td>";	 
					echo stripslashes($row['firstname'])." ".stripslashes($row['lastname']);  
					echo "</td><td>";	 
					echo stripslashes($row['gamesplayed']);	
					echo "</td><td>";	 
					echo stripslashes($row['goals']);
					echo "</td><td>";
					echo stripslashes($row['assists']);
					echo "</td><td>";
					echo stripslashes($row['points']);
					echo "</td><td>";
					echo stripslashes($row['pim']);
					echo "</td><td>";
					echo stripslashes($row['plusminus']);
					echo "</td>";
			 echo "</tr>";
			}
		echo "</table>";   
}
?>
	<form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" id="search">
		<select name='statsYear' id='statsYear' class='dropDown' onchange='this.form.submit()'>
			<option <?php if (($_GET['statsYear'] == '2016-2017') || !isset($_GET['statsYear'])) { ?>selected="true" <?php }; ?>value="2016-2017">2016-2017</option>
			<option <?php if ($_GET['statsYear'] == '2015-2016') { ?>selected="true" <?php }; ?>value="2015-2016">2015-2016</option>
			<option <?php if ($_GET['statsYear'] == '2014-2015') { ?>selected="true" <?php }; ?>value="2014-2015">2014-2015</option>
			<option <?php if ($_GET['statsYear'] == '2013-2014') { ?>selected="true" <?php }; ?>value="2013-2014">2013-2014</option>
			<option <?php if ($_GET['statsYear'] == '2012-2013') { ?>selected="true" <?php }; ?>value="2012-2013">2012-2013</option>
			<option <?php if ($_GET['statsYear'] == '2011-2012') { ?>selected="true" <?php }; ?>value="2011-2012">2011-2012</option>
			<option <?php if ($_GET['statsYear'] == '2010-2011') { ?>selected="true" <?php }; ?>value="2010-2011">2010-2011</option>
			<option <?php if ($_GET['statsYear'] == '2009-2010') { ?>selected="true" <?php }; ?>value="2009-2010">2009-2010</option>
			<option <?php if ($_GET['statsYear'] == '2008-2009') { ?>selected="true" <?php }; ?>value="2008-2009">2008-2009</option>
			<option <?php if ($_GET['statsYear'] == '2007-2008') { ?>selected="true" <?php }; ?>value="2007-2008">2007-2008</option>
		</select>
		<select name='statsTeam' id='statsTeam' class='dropDown' onchange='this.form.submit()'>
			<option <?php if ($_GET['statsTeam'] == '29') { ?>selected="true" <?php }; ?>value="29">Anaheim</option>
			<option <?php if ($_GET['statsTeam'] == '30') { ?>selected="true" <?php }; ?>value="30">Arizona</option>
			<option <?php if ($_GET['statsTeam'] == '11') { ?>selected="true" <?php }; ?>value="11">Boston</option>
			<option <?php if ($_GET['statsTeam'] == '15') { ?>selected="true" <?php }; ?>value="15">Buffalo</option>
			<option <?php if ($_GET['statsTeam'] == '3') { ?>selected="true" <?php }; ?>value="3">Carolina</option>
			<option <?php if ($_GET['statsTeam'] == '19') { ?>selected="true" <?php }; ?>value="19">Columbus</option>
			<option <?php if ($_GET['statsTeam'] == '23') { ?>selected="true" <?php }; ?>value="23">Calgary</option>
			<option <?php if ($_GET['statsTeam'] == '20') { ?>selected="true" <?php }; ?>value="20">Chicago</option>
			<option <?php if ($_GET['statsTeam'] == '22') { ?>selected="true" <?php }; ?>value="22">Colorado</option>
			<option <?php if ($_GET['statsTeam'] == '27') { ?>selected="true" <?php }; ?>value="27">Dallas</option>
			<option <?php if ($_GET['statsTeam'] == '16') { ?>selected="true" <?php }; ?>value="16">Detroit</option>
			<option <?php if ($_GET['statsTeam'] == '24') { ?>selected="true" <?php }; ?>value="24">Edmonton</option>
			<option <?php if ($_GET['statsTeam'] == '4') { ?>selected="true" <?php }; ?>value="4">Florida</option>
			<option <?php if ($_GET['statsTeam'] == '28') { ?>selected="true" <?php }; ?>value="28">Los Angeles</option>
			<option <?php if ($_GET['statsTeam'] == '25') { ?>selected="true" <?php }; ?>value="25">Minnesota</option>
			<option <?php if ($_GET['statsTeam'] == '14') { ?>selected="true" <?php }; ?>value="14">Montreal</option>
			<option <?php if ($_GET['statsTeam'] == '7') { ?>selected="true" <?php }; ?>value="7">New Jersey</option>
			<option <?php if ($_GET['statsTeam'] == '18') { ?>selected="true" <?php }; ?>value="18">Nashville</option>
			<option <?php if ($_GET['statsTeam'] == '9') { ?>selected="true" <?php }; ?>value="9">NYI</option>
			<option <?php if ($_GET['statsTeam'] == '8') { ?>selected="true" <?php }; ?>value="8">NYR</option>
			<option <?php if ($_GET['statsTeam'] == '13') { ?>selected="true" <?php }; ?>value="13">Ottawa</option>
			<option <?php if ($_GET['statsTeam'] == '6') { ?>selected="true" <?php }; ?>value="6">Philadelphia</option>
			<option <?php if ($_GET['statsTeam'] == '10') { ?>selected="true" <?php }; ?>value="10">Pittsburgh</option>
			<option <?php if (($_GET['statsTeam'] == '26') || !isset($_GET['statsTeam'])) { ?>selected="true" <?php }; ?>value="26">San Jose</option>
			<option <?php if ($_GET['statsTeam'] == '17') { ?>selected="true" <?php }; ?>value="17">St Louis</option>
			<option <?php if ($_GET['statsTeam'] == '1') { ?>selected="true" <?php }; ?>value="1">Tampa Bay</option>
			<option <?php if ($_GET['statsTeam'] == '12') { ?>selected="true" <?php }; ?>value="12">Toronto</option>
			<option <?php if ($_GET['statsTeam'] == '21') { ?>selected="true" <?php }; ?>value="21">Vancouver</option>
			<option <?php if ($_GET['statsTeam'] == '47') { ?>selected="true" <?php }; ?>value="47">Winnipeg</option>
			<option <?php if ($_GET['statsTeam'] == '5') { ?>selected="true" <?php }; ?>value="5">Washington</option>
		</select>
	</form>
<?php
	if ((isset($_GET['statsYear'])) && (isset($_GET['statsTeam']))) {                 
		$season = $_GET['statsYear'];
		$teamid = $_GET['statsTeam'];
	} else {
			// The following code will determine the $season in this format: '2015-2016' '2016-2017' for database entry
			$year = date('Y');
			$checkDate = date('m/d/Y');
			$checkDate=date('m/d/Y', strtotime($checkDate));
			$lowerBound = date('m/d/Y', strtotime("01/01/$year"));
			$upperBound = date('m/d/Y', strtotime("10/01/$year"));

			if (($checkDate >= $lowerBound) && ($checkDate < $upperBound)) {	
				$season = date('Y', strtotime('-1 years'));
				$season .= "-".date('Y');
			} else {
				$season = date('Y');
				$season .= "-".date('Y', strtotime('+1 years'));  
			}  
				$teamid = "26";
		}
	$query = $db->prepare("SELECT * FROM stats
						WHERE teamid = :teamid AND season = :season AND position != 'G'
						ORDER BY points DESC");
	$query->bindParam(':teamid', $teamid);
	$query->bindParam(':season', $season);
	$query->execute();
	$result = $query->fetchAll();
	
	echoTable($result); 
	
	$query = $db->prepare("SELECT * FROM playoff_stats
					WHERE teamid = :teamid AND season = :season AND position != 'G'
					ORDER BY points DESC");
	$query->bindParam(':teamid', $teamid);
	$query->bindParam(':season', $season);
	$query->execute();
	$result = $query->fetchAll();
	
	if ($result) {
		echo "<h2>Playoff Statistics</h2>";
		echoTable($result);
	}

?>
		</div>		
		<?php include 'pictures.php' ; ?>
	<?php include 'footer.php' ; ?>
</div>
</div>
</html>