<?php include 'header.php'; ?>  
	<div id="wrapper">
	<div id="container">
<?php include 'news.php' ; ?>
	<div id="content">
	<h2>League Leaders Regular Season</h2>
<?php
try {   
	$db = new PDO('sqlite:../../SharksDB/SharksDB');  
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
} catch (Exception $e) {  
	 echo "Error: Could not connect to database.  Please try again later.";
	 exit;
}	

if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {	
	$page = 1 ;
}

if (isset($_GET['statsType'])) {
	$statsType = $_GET['statsType'];
} else {	
	$statsType = 'points' ;
}
if (isset($_GET['statsYear'])) {
	$season = $_GET['statsYear'];
} else {
	  $year = date('Y');
		$checkDate = date('m/d/Y');
    $checkDate=date('m/d/Y', strtotime($checkDate));
    $lowerBound = date('m/d/Y', strtotime("01/01/$year"));
    $upperBound = date('m/d/Y', strtotime("10/12/$year"));
		
		if (($checkDate >= $lowerBound) && ($checkDate < $upperBound)) {
			
			$season = date('Y', strtotime('-1 years'));
			$season .= date('Y');
    } else {
      $season = date('Y');
      $season .= date('Y', strtotime('+1 years'));  
    }
}

////////////////////// PAGINATION Setup///////////////////////////////////////////////////////	
	
	// page is the current page, if there's nothing set, default is page 1
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	
	// set records or rows of data per page
	$recordsPerPage = 20;
	
	// calculate lower number for the query LIMIT clause
	$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;
	
	// count the players for pagination
	$query = $db->prepare("SELECT COUNT(id) FROM player_stats WHERE season = :season");
	$query->bindParam(':season' , $season);
	$query->execute();
	$player_count = $query->fetchColumn(); 

////////////////// Select player stats, but don't echo /////////////////////////
	
	$query1 = $db->prepare("SELECT player_stats.*, teams.*
						FROM player_stats
						LEFT JOIN teams ON player_stats.tid = teams.teamid
						WHERE season = :season
						ORDER BY ".$statsType." DESC, points DESC, goals DESC, gp ASC 
						LIMIT $fromRecordNum , $recordsPerPage");
						
	$query1->bindParam(':season', $season);
	$query1->execute();
	$result1 = $query1->fetchAll();
	
//////////////////// PLAYOFF STATS ///////////////////////////////////////////////	
	
  $query2 = $db->prepare("SELECT player_stats_playoffs.*, teams.*
					 FROM player_stats_playoffs
					 LEFT JOIN teams ON player_stats_playoffs.tid = teams.teamid
					 WHERE season = :season 
					 ORDER BY ".$statsType." DESC, points DESC, goals DESC, gp ASC
					 LIMIT $fromRecordNum , $recordsPerPage");
  $query2->bindParam(':season', $season);
  $query2->execute();
  $result2 = $query2->fetchAll();
	 
?>
<form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?statsYear{$season}&statsType={$statsType}&page=$page'";?>" method="get" id="search">
	<select name='statsYear' id='statsYear' class='dropDown' onchange='this.form.submit()'>
		<option <?php if (($_GET['statsYear'] == '20162017') || !isset($_GET['statsYear'])) { ?>selected="true" <?php }; ?>value="20162017">2016-2017</option>
		<option <?php if ($_GET['statsYear'] == '20152016') { ?>selected="true" <?php }; ?>value="20152016">2015-2016</option>
		<option <?php if ($_GET['statsYear'] == '20142015') { ?>selected="true" <?php }; ?>value="20142015">2014-2015</option>
		<option <?php if ($_GET['statsYear'] == '20132014') { ?>selected="true" <?php }; ?>value="20132014">2013-2014</option>
		<option <?php if ($_GET['statsYear'] == '20122013') { ?>selected="true" <?php }; ?>value="20122013">2012-2013</option>
	</select>
		<select  name="statsType" id="statsType" class="dropDown" onchange='this.form.submit()'>
		<option <?php if ($_GET['statsType'] == 'points'  || !isset($_GET['statsType'])) { ?>selected="true" <?php }; ?> value="points">Points</option>
		<option <?php if ($_GET['statsType'] == 'goals') { ?>selected="true" <?php }; ?> value="goals">Goals</option>
		<option <?php if ($_GET['statsType'] == 'assists') { ?>selected="true" <?php }; ?>value="assists">Assists</option>
		<option <?php if (($_GET['statsType'] == 'pim') ) { ?>selected="true" <?php }; ?>value="pim">PIM</option>
		<option <?php if ($_GET['statsType'] == 'plsmns') { ?>selected="true" <?php }; ?>value="plsmns"ns>+/-</option>
		<option <?php if (($_GET['statsType'] == 'toi') ) { ?>selected="true" <?php }; ?>value="toi">TOI</option>
	</select>
</form>
<?php
//////////////////////// Display PAGINATION Arrows /////////////////////////////////////////

	$total_pages = ceil($player_count / $recordsPerPage);

	if($page > 0 ) { 	
		echo "<a href='" . $_SERVER['PHP_SELF'] . "?statsYear={$season}&statsType={$statsType}&page=1' title='Go to the first page.' class='customBtn'>"; echo "<span style='margin:0 .5em;'> << </span>"; echo "</a>"; 	
		$prev_page = $page - 1; 
		echo "<a href='" . $_SERVER['PHP_SELF'] . "?statsYear={$season}&statsType={$statsType}&page={$prev_page}' title='Previous page is {$prev_page}.' class='customBtn'>"; echo "<span style='margin:0 .5em;'> < </span>"; echo "</a>"; 		
	}
	
	// range of num links to show
	$range = 2;
	 
	// display links to 'range of pages' around 'current page'
	$initial_num = $page - $range;
	$condition_limit_num = ($page + $range)  + 1;
	 
	for ($x=$initial_num; $x<$condition_limit_num; $x++) {
			 
			// be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
			if (($x > 0) && ($x <= $total_pages)) {
			 
					// current page
					if ($x == $page) {
							echo "<span class='customBtn' style='color:white; margin:0 .5em;'>$x</span>";
					} 
					// not current page
					else {
							echo "<a href='" . $_SERVER['PHP_SELF'] . "?statsYear={$season}&statsType={$statsType}&page=$x' class='customBtn'>$x</a> ";
					}
			}
	}
	
	if($page < $total_pages){
			// ********** show the next page
			$next_page = $page + 1;
			echo "<a href='" . $_SERVER['PHP_SELF'] . "?statsYear={$season}&statsType={$statsType}&page={$next_page}' title='Next page is {$next_page}.' class='customBtn'>";
					echo "<span style='margin:0 .5em;'> > </span>";
			echo "</a>";
			 
			// ********** show the last page
			echo "<a href='" . $_SERVER['PHP_SELF'] . "?statsYear={$season}&statsType={$statsType}&page={$total_pages}' title='Last page is {$total_pages}.' class='customBtn'>";
					echo "<span style='margin:0 .5em;'> >> </span>";
			echo "</a>";
	}
//////////////////////////// END OF PAGINATION /////////////////////////////////////	

  function echoTable($result1or2, $page)	{	
		echo "<table class='table sortable2'>";	
		echo "<tr class='TableHeaders'>";
		echo "<td class='hover' width='3%'>RK</td>";
		echo "<td class='hover' width='5%'>Team</td>";
		echo "<td class='hover' width='10%'>Name</td>";
		echo "<td class='hover' width='5%'>GP</td>";
		echo "<td class='hover' width='5%'>G</td>";
		echo "<td class='hover' width='5%'>A</td>";
		echo "<td class='hover' width='5%'>Pts</td>";
		echo "<td class='hover' width='5%'>PIM</td>";
		echo "<td class='hover' width='5%'>+/-</td>";
		echo "<td class='hover' width='5%'>ATOI</td>";
		echo "</tr>";
		
		if ($page == 1) {
			$i =  1; 
		} else {
				$i = 1 + (($page-1) * 20);
			}
			
		foreach ($result1or2 as $row) {
			$points = ($row['goals'] + $row['assists']); 
			$logo = $row['logo'];
			echo "<tr>";
				echo "<td>";
				echo $i;
				echo "</td><td>";
				echo "<img src='$logo' height='30px'>";
				echo "</td><td>";	 
				echo stripslashes($row['name']);  
				echo "</td><td>";	 
				echo stripslashes($row['gp']);	
				echo "</td><td>";	 
				echo stripslashes($row['goals']);
				echo "</td><td>";
				echo stripslashes($row['assists']);
				echo "</td><td>";
				echo stripslashes($row['points']);
				echo "</td><td>";
				echo stripslashes($row['pim']);
				echo "</td><td>";
				echo stripslashes($row['plsmns']);
				echo "</td><td>";
				echo stripslashes($row['toi']);
				echo "</td>";
		 echo "</tr>";
		 $i++;
		}
		echo "</table>";
	}
	
  echoTable($result1, $page);
		
	if ($result2) {
		echo "<h2> League Playoff Leaders </h2>";
		echoTable($result2, $page);
	}
		
?>
		</div>		
		<?php include 'pictures.php' ; ?>
	<?php include 'footer.php' ; ?>
</div>
</div>
</html>