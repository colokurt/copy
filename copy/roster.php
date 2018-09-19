<?php
	ini_set('error_reporting', E_ERROR);
	try {   
		$db = new PDO('sqlite:../../SharksDB/SharksDB');  
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
	} catch (Exception $e) {  
		 echo "Error: Could not connect to database.  Please try again later.";
		 exit;
	}
  $rosterYear = $_GET['rosterYear'];
	$year = date('Y');
	$checkDate = date('m/d/Y');
	$checkDate=date('m/d/Y', strtotime($checkDate));
	$lowerBound = date('m/d/Y', strtotime("01/01/$year"));
	$upperBound = date('m/d/Y', strtotime("08/01/$year"));

	if (($checkDate >= $lowerBound) && ($checkDate < $upperBound)) {	
		$season = date('Y', strtotime('-1 years'));
		$season .= date('Y');
	} else {
		$season = date('Y');
		$season .= date('Y', strtotime('+1 years'));  
	}  
	
	$season1 = substr($season, 0, -4);  
	$season2 = substr($season, -4);  
	
	$query = $db->prepare("SELECT teamid, teamAcronym FROM teams");
	$query->execute();
	$result = $query->fetchAll();
	
	
	foreach ( $result as $row ) {
		$teamid = $row['teamid'];
		$teamAcronym = $row['teamAcronym'];
		
	}
	
	$json = file_get_contents('http://nhlwc.cdnak.neulion.com/fs1/nhl/league/teamroster/SJS/iphone/clubroster.json');
	$json = json_decode($json, TRUE);
	
	$goalie = $json['goalie'];
	$defensemen = $json['defensemen'];
	$forwards = $json['forwards'];
	
	$query = "INSERT OR IGNORE INTO rosters ('position','id','weight','height','imageURL','birthplace','age','name','birthdate','number', 'season')
						VALUES (:position, :id, :weight, :height , :imageURL, :birthplace , :age , :name , :birthdate , :number, :season)";
	$prepare = $db->prepare($query);
	
	$query2 = "UPDATE rosters
						 SET position= :position, id= :id, weight= :weight, height= :height, imageURL= :imageURL, birthplace= :birthplace, age= :age, name= :name,
						 birthdate= :birthdate, number= :number, season= :season
						 WHERE id= :id AND season= :season"; 
	$prepare2 = $db->prepare($query2);
	
  $resultArray = array(); // array to hold all arrays
	$goalie = array();
	if (is_array($json['goalie']) && count($json['goalie']) > 0) {
			$goalie = $json['goalie'];
	}

	$defensemen = array();
	if (is_array($json['defensemen']) && count($json['defensemen']) > 0) {
			$defensemen = $json['defensemen'];
	}
	$resultArray = array_merge($goalie, $defensemen);

	$forwards = array();
	if (is_array($json['forwards']) && count($json['forwards']) > 0) {
			$forwards = $json['forwards'];
	}

	$resultArray = array_merge($resultArray, $forwards);

	foreach ($resultArray as $pd) {
		$position = $pd['position'];
		if ($position == "Goalie") {
			$position = "G";
		} 
		if ($position == "Left Wing") {
			$position = "LW";
		}
		if ($position == "Right Wing") {
			$position = "RW";
		} 
		if ($position == "Defenseman") {
			$position = "D";
		} 
		if ($position == "Center") {
			$position = "C";
		}
			$a = array(':position' => $position ,
					':season' => $season = $season,
					':id' => $id = $pd['id'],
					':weight' => $weight = $pd['weight'],
					':height' => $height = $pd['height'],
					':imageURL' => $imageURL = $pd['imageUrl'],
					':birthplace' => $birthplace = $pd['birthplace'],
					':age' => $age = $pd['age'],
					':name' => $name = $pd['name'],
					':birthdate' => $birthdate = $pd['birthdate'],
					':number' => $number = $pd['number']);

			$prepare->execute($a);
			$prepare2->execute($a);
	}
	
	function echoTable($result) {
		echo "<table class='table sortable'>";	
		echo "<tr class='TableHeaders'>";
		echo "<td class='hover' width='8%' >No</td>";
		echo "<td class='hover'>Name</td>";
		echo "<td class='hover' width='8%'>Pos</td>";
		echo "<td class='hover' width='8%'>Ht</td>";
		echo "<td class='hover' width='8%'>Wt</td>";
		echo "<td class='hover' width='8%'>Age</td>";
		echo "<td class='hover'>Birth Date</td>";
		echo "</tr>";	
		
		foreach ($result as $row) {
			$imageURL = $row['imageURL'];
			echo "<tr>";
				echo "<td>";
				echo stripslashes($row['number']); 
				echo "</td><td>";
				echo stripslashes($row['name']);
				echo "</td><td>";				
				echo stripslashes($row['position']);  
				echo "</td><td>";	 
				echo stripslashes($row['height']);	
				echo "</td><td>";	 
				echo stripslashes($row['weight']);
				echo "</td><td>";
				echo stripslashes($row['age']);
				echo "</td><td>";
				echo stripslashes($row['birthdate']);
				echo "</td>";
			echo "</tr>";	  
			$db = null;
		}
		echo "</table>";
	}	
?>
<?php include 'header.php'; ?>  
	<div id="container">
		<?php include 'news.php' ; ?>		
			<div id="content">
			<h2>Roster</h2>
				<form action= "<?php echo $_SERVER['PHP_SELF'];?>" method="get" id="search">  
					<select name="rosterYear" id="rosterYear" class="dropDown" onchange='this.form.submit()'>
						<option selected value="" disabled>Select Year</option>
						<option <?php if ($_GET['rosterYear'] == '20162017') { ?>selected="true" <?php }; ?>value="20162017">2016-2017</option>
						<option <?php if ($_GET['rosterYear'] == '20152016') { ?>selected="true" <?php }; ?>value="20152016">2015-2016</option>
						<option <?php if ($_GET['rosterYear'] == '20142015') { ?>selected="true" <?php }; ?>value="20142015">2014-2015</option>
					</select>
				</form>
					<?php 
						if (isset($_GET['rosterYear'])) {
							$query = $db->prepare("SELECT * FROM rosters WHERE season = :rosterYear ORDER BY 'id'");
							$query->bindParam(':rosterYear', $rosterYear);
							$query->execute();
							$result = $query->fetchAll();
							echoTable($result);
						} else {
							$query = $db->prepare("SELECT * FROM rosters WHERE season = :season ORDER BY 'id'");
							$query->bindParam(':season', $season);
							$query->execute();
							$result = $query->fetchAll();
							echoTable($result);
							}
						$db = null;	
					?>
			</div>		
			<?php include 'pictures.php' ; ?>
		<?php include 'footer.php' ; ?>
	</div>
</div> 
</html>