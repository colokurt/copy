function showHeaderFor(date) {
 var url = (date) ? 'get_scores.php?date=' + date : 'get_scores.php';
  $.get(url, function(header) { 
		$('#ajaxScores').html(header);
	})
};

$( function() { 
	setInterval(customDateUrl, 30000); 
	$("#datepicker").hide();
	

});  // $() shortcut for run this as soon as page loads.

$("#buttonHere").click(function(){
	$("#datepicker").toggle();
}); 

$("#datepicker").datepicker({	 
	onSelect: function(value, date) { 
		 alert('The chosen date is ' + value); 
		 $("#datepicker").hide(); 
	} 
});

function customDateUrl() {
	var month = $("#month").val();
	var day = $("#day").val();
	var year = $("#year").val();
	
	var customDate = year + "-" + month + "-" + day ;
	showHeaderFor(customDate);
    
}