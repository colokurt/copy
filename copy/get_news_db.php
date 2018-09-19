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
	
	$xmlDoc = new DOMDocument();
	$xmlDoc->load('http://thehockeywriters.com/category/san-jose-sharks/feed/');
	$searchNode = $xmlDoc->getElementsByTagName("item");
	$i = 0;
	
	function bindParamNewsFeed($query, $title, $desc, $link, $pubDate) {
		$query->bindParam(':title', $title);
		$query->bindParam(':desc', $desc);
		$query->bindParam(':link', $link);
		$query->bindParam(':pubdate', $pubDate);	
	}	

foreach ($searchNode as $searchNode) {
		if ($i==6) break;
		$title = $searchNode->getElementsByTagName('title');
		$title = $title->item(0)->nodeValue;
		$desc = $searchNode->getElementsByTagName('description');
		$desc = $desc->item(0)->nodeValue;
		$link = $searchNode->getElementsByTagName('link');
		$link = $link->item(0)->nodeValue;
		$pubDate = $searchNode->getElementsByTagName('pubDate');
		$pubDate = $pubDate->item(0)->nodeValue;
		$pubDate = explode(" ",$pubDate);
		
		$month = $pubDate[2];
		switch ($month) {
				case "Jan":
						$month = "01";
						break;
				case "Feb":
						$month = "02";
						break;
				case "Mar":
						$month = "03";
						break;
				case "Apr":
						$month = "04";
						break;
				case "May":
						$month = "05";
						break;
				case "June":
						$month = "06";
						break;
				case "July":
						$month = "07";
						break;
				case "Aug":
						$month = "08";
						break;
				case "Sep":
						$month = "09";
						break;
				case "Oct":
						$month = "10";
						break;
				case "Nov":
						$month = "11";
						break;
				case "Dec":
						$month = "12";
						break;
				default:
					  $month = "xx";
		}
		$pubDate = $pubDate[3]."-".$month."-".$pubDate[1];

	$query = $db->prepare("INSERT OR IGNORE INTO news ('title','desc','link','pubdate')
								         VALUES (:title, :desc, :link, :pubdate)");
			
	bindParamNewsFeed($query, $title, $desc, $link, $pubDate);
  $query->execute();
}
?>