$(function(){
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd",
		duration: "fast",
		// 시간까지 사용할 경우 주석 해제하고 사용하시면 됩니다.
		onSelect: function(datetext) {
		    var d = new Date(); // for now
	
		    var h = d.getHours();
		    h = (h < 10) ? ("0" + h) : h ;
	
		    var m = d.getMinutes();
		    m = (m < 10) ? ("0" + m) : m ;
	
		    var s = d.getSeconds();
		    s = (s < 10) ? ("0" + s) : s ;
	
		    datetext = datetext + " " + h + ":" + m + ":" + s;
	
		    $('.datepicker').val(datetext);
		}
	});

	$( ".datepicker2" ).datepicker({
		dateFormat: "yy-mm-dd",
		duration: "fast",
		// 시간까지 사용할 경우 주석 해제하고 사용하시면 됩니다.
		// onSelect: function(datetext) {
		//     var d = new Date(); // for now
	
		//     var h = d.getHours();
		//     h = (h < 10) ? ("0" + h) : h ;
	
		//     var m = d.getMinutes();
		//     m = (m < 10) ? ("0" + m) : m ;
	
		//     var s = d.getSeconds();
		//     s = (s < 10) ? ("0" + s) : s ;
	
		//     datetext = datetext + " " + h + ":" + m + ":" + s;
	
		//     $('.datepicker2').val(datetext);
		// }
	});
	$( ".datepicker3" ).datepicker({
		dateFormat: "yy-mm-dd",
		duration: "fast",
		// 시간까지 사용할 경우 주석 해제하고 사용하시면 됩니다.
		// onSelect: function(datetext) {
		//     var d = new Date(); // for now
	
		//     var h = d.getHours();
		//     h = (h < 10) ? ("0" + h) : h ;
	
		//     var m = d.getMinutes();
		//     m = (m < 10) ? ("0" + m) : m ;
	
		//     var s = d.getSeconds();
		//     s = (s < 10) ? ("0" + s) : s ;
	
		//     datetext = datetext + " " + h + ":" + m + ":" + s;
	
		//     $('.datepicker2').val(datetext);
		// }
	});
	$(".datetimepicker1").datetimepicker({ 
		format: "Y-m-d H:i:00",
		step : 5
	});
});