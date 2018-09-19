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
function get_JSONP($url){
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
function bindParam($query, $id, $ata, $atc, $atCommon, $atn, $ats, $atsog, $hta, $htc, $htCommon, $htn, $hts, $htsog, $bs, $bsc, $caNationalBroadcasts, $gcl, $gcl1, $gs, $r1, $usNationalBroadcasts, $season) {
	$query->bindParam(':id', $id);
	$query->bindParam(':ata', $ata);
	$query->bindParam(':atc', $atc);
	$query->bindParam(':atcommon', $atCommon);
	$query->bindParam(':atn', $atn);
	$query->bindParam(':ats', $ats);
	$query->bindParam(':atsog', $atsog);
	$query->bindParam(':hta', $hta);
	$query->bindParam(':htc', $htc);
	$query->bindParam(':htcommon', $htCommon);
	$query->bindParam(':htn', $htn);
	$query->bindParam(':hts', $hts);
	$query->bindParam(':htsog', $htsog);
	$query->bindParam(':bs', $bs);
	$query->bindParam(':bsc', $bsc);
	$query->bindParam(':canationalbroadcasts', $caNationalBroadcasts);
	$query->bindParam(':gcl', $gcl);
	$query->bindParam(':gcl1', $gcl1);
	$query->bindParam(':gs', $gs);
	$query->bindParam(':r1', $r1);
	$query->bindParam(':usnationalbroadcasts', $usNationalBroadcasts);
	$query->bindParam(':season', $season); 			
}				

// Following code will determine the $season in this format ex: 20152016 
	$year = date('Y');
	$checkDate = date('m/d/Y');
	$checkDate=date('m/d/Y', strtotime($checkDate));
	$lowerBound = date('m/d/Y', strtotime("01/01/$year"));
	$upperBound = date('m/d/Y', strtotime("10/01/$year"));

	if (($checkDate >= $lowerBound) && ($checkDate < $upperBound)) {	
		$season = date('Y', strtotime('-1 years'));
		$season .= date('Y');

	} else {
		$season = date('Y');
		$season .= date('Y', strtotime('+1 years'));	
	}
	$dateURLFormatted = date("Y-m-d"); 
	$iteratingSeason = substr($season , 0, -4);
	$iteratingDate = $iteratingSeason.'-10-01';

	while ($iteratingDate <= $dateURLFormatted) {
		$iteratingDate = new DateTime($iteratingDate);
		$iteratingDate->add(new DateInterval('P1D')); // Period 1 Day
		$iteratingDate = $iteratingDate->format('Y-m-d');
		$url = "http://live.nhle.com/GameData/GCScoreboard/".$iteratingDate.".jsonp";
		$jsonp = get_JSONP($url);
		$json = jsonp_decode($jsonp);
		
		foreach ($json->games as $game) {
			$atCommon = $game->atcommon; // away team common name
			$id = $game->id; // game id
			$caNationalBroadcasts = $game->canationalbroadcasts; 
			$ata = $game->ata; // away team acronym
			$r1 = $game->r1; // Bool true if game over
			$atsog = $game->atsog; // away shots
			$bs = $game->bs; // start time 
			$htCommon = $game->htcommon; // home team common name
			$atn = $game->atn; // away team city
			$hts = $game->hts; // home team score
			$atc = $game->htc; // away team "winner" if wins
			$htn = $game->htn; // home team city
			$usNationalBroadcasts = $game->usnationalbroadcasts;
			$gcl = $game->gcl; // GCL boolean
			$hta = $game->hta; // home team acronym
			$ats = $game->ats; // away team score
			$htc = $game->htc; // home team "winner" if wins
			$htsog = $game->htsog; // ht sog 
			$bsc = $game->bsc; // During : "progress" After: "final"
			$gs = $game->gs; // game status
			$gcl1 = $game->gcl1;		// GCL boolean
			
			$query = $db->prepare("INSERT OR IGNORE INTO results ('id','ata','atc','atcommon','atn','ats','atsog','hta','htc','htcommon','htn','hts','htsog','bs','bsc','canationalbroadcasts','gcl','gcl1','gs','r1','usnationalbroadcasts', season)
								   VALUES (:id, :ata, :atc, :atcommon, :atn, :ats, :atsog, :hta, :htc, :htcommon, :htn, :hts, :htsog, :bs, :bsc, :canationalbroadcasts, :gcl, :gcl1, :gs, :r1, :usnationalbroadcasts, :season)");
			
			bindParam($query, $id, $ata, $atc, $atCommon, $atn, $ats, $atsog, $hta, $htc, $htCommon, $htn, $hts, $htsog, $bs, $bsc, $caNationalBroadcasts, $gcl, $gcl1, $gs, $r1, $usNationalBroadcasts, $season);
			$query->execute();
			

			$query = $db->prepare("UPDATE results
								   SET id=:id, ata=:ata, atc=:atc, atcommon=:atcommon, atn=:atn, ats=:ats, atsog=:atsog, hta=:hta, htc=:htc, htcommon=:htcommon, htn=:htn, hts=:hts, htsog=:htsog, bs=:bs, bsc=:bsc, 
								   canationalbroadcasts=:canationalbroadcasts, gcl=:gcl, gcl1=:gcl1, gs=:gs, r1=:r1, usnationalbroadcasts=:usnationalbroadcasts, season=:season
								   WHERE id=:id AND season=:season");
														 
			bindParam($query, $id, $ata, $atc, $atCommon, $atn, $ats, $atsog, $hta, $htc, $htCommon, $htn, $hts, $htsog, $bs, $bsc, $caNationalBroadcasts, $gcl, $gcl1, $gs, $r1, $usNationalBroadcasts, $season);
			$query->execute();
		}
	} 
?>