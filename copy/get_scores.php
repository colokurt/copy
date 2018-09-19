<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1); 
try {   
	$db = new PDO('sqlite:../../SharksDB/SharksDB');  
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
} catch (Exception $e) {  
		echo "Error: Could not connect to database.  Please try again later.";
		exit;
	}
function get_JSONP($url) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);

			return $output;
}
function jsonp_decode($jsonp, $assoc = false) { // PHP 5.3 adds depth as third parameter to json_decode
		if($jsonp[0] !== '[' && $jsonp[0] !== '{') { 
				$jsonp = substr($jsonp, strpos($jsonp, '('));
		}
		$jsonp = trim($jsonp);      // remove trailing newlines
		$jsonp = trim($jsonp,'()'); // remove leading and trailing parenthesis

		return json_decode($jsonp);
}
	
	
	if ($_GET['date'] != '') { 
		$now = $_GET['date'];
		$dateURLFormatted =  DateTime::createFromFormat("Y-m-d", $now);
	} else { 
			$now = date('Y-m-d'); 
			$dateURLFormatted =  DateTime::createFromFormat("Y-m-d", $now);
		}
	
	$dateURLFormattedPrev =  DateTime::createFromFormat("Y-m-d", $now);
	$dateURLFormattedPrev = $dateURLFormattedPrev->modify('-1 day');

	$dateURLFormattedNext =  DateTime::createFromFormat("Y-m-d", $now);
	$dateURLFormattedNext = $dateURLFormattedNext->modify('+1 day');
 
	$url = "http://live.nhle.com/GameData/GCScoreboard/".$dateURLFormatted->format('Y-m-d').".jsonp";
	$jsonp = get_JSONP($url);
	$json = jsonp_decode($jsonp);
?>	
<table class="scoresHeader"> 
	<tr>
		<td><button type='button' class='scoreButton' onclick='showHeaderFor("<?php echo $dateURLFormattedPrev->format('Y-m-d'); ?>")'>Prev</button></td>
		<td><h5> Scoreboard <?php echo $dateURLFormatted->format('M d, Y'); ?>  </h5></td>
		<td><button type='button' class='scoreButton' onclick='showHeaderFor("<?php echo $dateURLFormattedNext->format('Y-m-d'); ?>")'>Next</button></td>
		<td> 
			<select class="dateDropDown" id="month" onchange='customDateUrl()'>
			<?php for ($i = 1; $i < 13; $i++) {
					if ($i < 10 ) {
						$i = "0".$i;
					}
					$m = $dateURLFormatted->format('m');
					if ( $m == $i ) {
						echo "<option class='option' selected>" . $i . " </option>" ;
					} else {
						echo "<option class='option'>" . $i . " </option>" ;
					  }
				  }
			?>
			</select>
		</td>
		<td> 
			   <select class="dateDropDown" id="day" onchange='customDateUrl()'>
				<?php for ($i = 1; $i < 32; $i++) {
					if ($i < 10 ) {
						$i = "0".$i;
					}
					$d = $dateURLFormatted->format('d');
						if ( $d == $i ) {
							echo "<option class='option' selected>" . $i . " </option>" ;
						} else {
							echo "<option class='option'>" . $i . " </option>" ;
						  }
					  }
				?>
				</select>
		</td>
	    <td> 
			 <select class="dateDropDown" id="year" onchange='customDateUrl()'>
				<?php for ($i = 2017; $i > 2012; $i--) {
						$Y = $dateURLFormatted->format('Y');
						if ( $Y== $i ) {
							echo "<option class='option' selected>" . $i . " </option>" ;
						} else {
							echo "<option class='option'>" . $i . " </option>" ;
						  }
					  }
				?>
			</select>
		</td>
	</tr>
</table>
<?php
echo '<table class="scores">';
	echo "<tr class='scoreResult'>";
		foreach($json->games as $game) {
			$bs = $game->bs;			
			echo "<td colspan='2'>";
			echo $bs;
			echo "</td>";
		}
	echo "</tr>";
	echo "<tr>";
		
		foreach($json->games as $game) {
			$hta = $game->hta;
			$hts = $game->hts;
			$htn = $game->htn; // home team city

			$query = $db->prepare("SELECT logo FROM teams WHERE UPPER(team_name) = (UPPER(:htn))");
			$query->bindParam(':htn', $htn);
			$query->execute();
			$result = $query->fetchAll();
			foreach ($result as $row) {
				$logo = $row['logo'];
			}
			?>
				<td><img src='<?php echo $logo; ?>' alt = '' height='32px' > </td><td><?php echo $hta.'&nbsp;&nbsp;'.$hts; ?></td>
			<?php
		}
			echo "</tr>";
			echo "<tr>";
			
			foreach($json->games as $game) {
				$ata = $game->ata;
				$ats = $game->ats;
				$atn = $game->atn; // away team city
				
				$query = $db->prepare("SELECT logo FROM teams WHERE UPPER(team_name) = (UPPER(:atn))");
				$query->bindParam(':atn', $atn);
				$query->execute();
				$result = $query->fetchAll();
				foreach ($result as $row) {
					$logo = $row['logo'];
				}
			?>
				<td><img src='<?php echo $logo; ?>' alt = '' height='32px' > </td><td><?php echo $ata.'&nbsp;&nbsp;'.$ats; ?></td>
			<?php
			}
		echo "</tr>";
		echo "</table>";
?>