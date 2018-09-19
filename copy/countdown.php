<?php include 'header.php'; ?>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script>
	var FantasyPlayers = ["Fresnel", "JakeBot", "Jenn-aaay", "Pug!","TheLeftShark", "Dmitriy","AthleticShark", "Timorous Me", "dfh15", "RZ39", "StaLOCK IT UP"
		, "EmKay- Lurker to the max", "thaSicness", "Seattle Thunderbirs (who is this guy?)", "Thornton Hears A Who", "MrDriscoll", "silverbucket", "KevinKurzBLOWS", "NYBroncosFan","kcam","SeniorChief", "BlueFog", "Damien Alambra", "B.D.Bronco", "boiseblues", "FanSince94 (not in the league looool)"];
	var FantasySmack = ["Thinks Microsoft Excel is GCL and still can't catch a ball","was never classy in San Diego", "Is going to take it hard by the end of the year (keyword 'end')", "All of your base ARE belongs to SJSDFan",
		"pfft, need I say more?","wore white before labor day..Feel the BURN!!!!","is that a pseudonym for the word poop?","learned how to watch hockey from Stevie Wonder", "is probably still beating me in fantasy..But That won't last long!",
		"has a pet gerbil named Eugene and is not above average at Fantasy Hockey", "actually did go to school naked once. That was not a dream, sorry" , "Thinks Kevin Kurz is dreamy",
		"did not vote for John Scott for the All Star Game. SHAME!"
		,"wants more #GRIT!", "Scored a B in Math once, NEWB =P", "did not get 2 front teeth for Christmas"
	  , "left a shopping cart out in the parking lot last week and the cart hit my CAR!", "Thinks that the Raptor is riding the Shark, when really it is the other way around"
		,"called for Stalock to start 2 seasons ago. I have links!", ": You picked nose today when no one was looking", "'You miss 100 percent of the shots you never take and also 100 percent of the shots you do take - Gretzky/Me'",
		"wore white before labor day..BURNED!!!! This is too easy", "lived in Tibet for 25 years and learned how to eat with chopsticks efficiently", "still thinks Matt Irwin is on the team", "is a big meanie and should give me their best player for uhmmm...Nick Holden"
		,"thinks that because you have nipples, you can be milked","was never classy in San Diego", "_demeaning_comment343_error2_misprint_error_default_error_msg1_!**html errno56:::Default::: I think you are not as cool as me and I have a better fantasy team so HA!"
		,"pooped in the refrigerator, but did not eat the whole wheel of cheese","had a team picnic once and forgot the baked beans."];
	function RndText() {
		var ranNum= Math.floor(Math.random() * FantasyPlayers.length);
		var ranNum2= Math.floor(Math.random() * FantasySmack.length);
		document.getElementById('ShowName').innerHTML = "<span style='color:red'>" + FantasyPlayers[ranNum] + "</span>" + " " + FantasySmack[ranNum2];
	}
	onload = function() { 
		RndText(); 
	}
	var inter = setInterval(function() { RndText(); }, 5000);
</script>
<script>
	$('#hiddenSurprise').hide(0);
	setInterval(function () {
		 var vis = $("#counter").css("visibility");
		 vis = (!vis || vis == "visible") ? "hidden" : "visible";
		 $("#counter").css("visibility", vis);
	}, 500);
</script>
<script>
	$(document).ready(function() {
    $("#hiddenSurprise").hide();
    $("#hiddenSurprise").delay(5000).fadeIn(200);
});
</script>
<script>
		var end = new Date('09/03/2016 12:00 PM');

    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {

            clearInterval(timer);
            document.getElementById('countdown').innerHTML = 'TIME FOR SOME FOOTBALL!';

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);
				var elem = document.getElementById("countdown");
						elem.style.color = " #F1632A";
						elem.style.fontSize = "large";
        document.getElementById('countdown').innerHTML = days + ' Days ';
        document.getElementById('countdown').innerHTML += hours + ' Hours ';
        document.getElementById('countdown').innerHTML += minutes + ' Minutes ';
        document.getElementById('countdown').innerHTML += seconds + ' Seconds';
    }

    timer = setInterval(showRemaining, 1000);
</script> 
<div id="wrapper">
		<div id="container">
<?php include 'news.php' ; ?>
		
		<div id="content">
			<h2 style="color: #09347A">Boise State Tracker!</h2>
			<audio controls autoplay>
				<source src="final.mp3" type="audio/mpeg">
			</audio>
			<br/>
			<div id="countdown"></div>
			<div id="counter">!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</div>
			<?php echo "Remaining..."; ?>
		<!--	<p id="ShowName"></p> -->
<?php
/* $rem = strtotime('2016-01-14 22:30:00') - time();
$day = floor($rem / 86400);
$hr  = floor(($rem % 86400) / 3600);
$min = floor(($rem % 3600) / 60);
$sec = ($rem % 60);
if($day) echo "$day Days ";
if($hr) echo "$hr Hours ";
if($min) echo "$min Minutes ";
if($sec) echo "$sec Seconds "; */
echo "<br /><br />";

?>
<img src="other/GIF/giphy.gif" alt=""width="400" height="250"/> 
<img src="other/GIF/guns.gif" alt="" width="400" height="250"/> <br />
<img src="other/GIF/bcs1_original.gif" alt="" width="400" height="250"/> 
<img src="other/GIF/statueofliberty.0.gif" alt=""width="400" height="250" /> <br />
</div>
		<?php include 'pictures.php' ; ?>
	<?php include 'footer.php' ; ?>

</div>
</html>