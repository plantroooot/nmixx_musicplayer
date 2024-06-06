$(function(){
	// Mobile Ui 
	
	var mobile = {
		open : function(){
			$('.mo_menu').stop().animate({'left':'0'},400);
		},
		close : function(){
			$('.mo_menu').stop().animate({'left':'-200%'}, 400);
		},
		down : function(target){
			$(target).addClass('on');
			$(target).next().stop().slideDown(400);
			
		},
		up : function(target){
			$(target).removeClass('on');
			$(target).next().stop().slideUp(400);
		},
		siblingsUp : function(target){
			$(target).parent().siblings('li').children('a').removeClass('on');
			$(target).parent().siblings('li').children('ul').stop().slideUp(400);
		},
		bgOn : function(){
			$('.mbg').stop().fadeIn(400);
		},
		bgOff : function(){
			$('.mbg').stop().fadeOut(400);
		}
	}

	
	$('.mo_open').on('click',function(){
		mobile.open();
		mobile.bgOn();
		//$('html,body').css({'overflow':'hidden' , 'height' : '100%'});
		//$.fn.fullpage.setAutoScrolling(false);
	});
	$('.mo_close').on('click',function(){
		mobile.close();
		mobile.bgOff();
		//$('html,body').css({'overflow':'visible' , 'height' : 'initial'});
	});

	$('.gnb-wrap ul.mo > li > a').on('click',function(){
		mobile.siblingsUp(this);
		if($(this).hasClass('on')){
			mobile.up(this);
		}else{
			mobile.down(this);
		}
	});
	

	/*$( ".datepicker" ).datepicker({
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

        //     $('.datepicker').val(datetext);
        // }
	});*/

	$('.sub-gnb1 > ul > li > a').on('click', function(){

		let $idx = $(this).parent().index();

		$(this).parent().siblings().children('a').removeClass('on');
		$('#sub.guide .img-area .img-wrap').css('display', 'none');
		$(this).addClass('on');
		$('#sub.guide .img-area .img-wrap').eq($idx).css('display', 'block');
		
	});


});

function openPopup(id){
	$('#'+id).css('display', 'block');
}

function closePopup(){
	$('.popup').css('display', 'none');
}

// $(document).on('click', function(e){
// 	// console.log(e.target.className);
// 	let targetClassName = e.target.className;
// 	if(targetClassName.indexOf('onclickStreaming') > -1 || targetClassName.indexOf('popup-body') > -1){
// 		// console.log(1);
// 		$('.popup').css('display', 'none');
// 	}
// });


// 팝업관련 js
function startTime(cName, pName) {

	cookieIndex = getCookie(cName);
	if ( cookieIndex ) {     
		document.getElementById(pName).style.display = "none";
		document.getElementById(cName).style.visibility = "hidden";
	} else {
		document.getElementById(pName).style.display = "block";
		document.getElementById(cName).style.visibility = "visible";
	}
}

function setCookieWeb( name, value ) {
	var expiredays = 1;			//공지창 하루 안띄우기 시간. 1은 하루임
	var todayDate = new Date();
	todayDate.setDate(todayDate.getDate() + expiredays);
	document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function closeLayer(cName, type , pName) {
    if ( type == 1) {
		setCookieWeb(cName, "os");
	}
	document.getElementById(pName).style.display = "none";
	document.getElementById(cName).style.visibility = "hidden";
}

function getCookie( name ) {
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length ) {
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
			endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}

		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
		break;
    }
    return "";
}

/* 삭제하지 말것 */
String.prototype.replaceAll = function(org, dest) {
    return this.split(org).join(dest);
}

function refresh_captcha(){
	document.getElementById("capt_img").src="/include/captcha.php?waste="+Math.random(); 
	return false;
}


/* - - - - - - - - - */ 