function startTime(cName, cMain, layerTop, layerLeft, layerWidth, layerHeight, type) {

	cookieIndex = getCookie(cName);
	if ( !cookieIndex || type == "0") {     
		document.getElementById(cName).style.visibility = "visible";
		document.getElementById(cName).style.display='block';
		document.getElementById(cName).parentNode.style.display='block';
	} else {
		document.getElementById(cName).style.visibility = "hidden";
		document.getElementById(cName).style.display = 'none';
		document.getElementById(cName).parentNode.style.display = 'none'; 
	}

    document.getElementById(cName).style.top = layerTop+"px";
    document.getElementById(cName).style.left = layerLeft+"px";
    document.getElementById(cName).style.width = layerWidth+"px";
    document.getElementById(cMain).style.height = layerHeight+"px";
}

function setCookieWeb( name, value ) {
	var expiredays = 1;			//공지창 하루 안띄우기 시간. 1은 하루임
	var todayDate = new Date();
	todayDate.setDate(todayDate.getDate() + expiredays);
	document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function closeLayer(cName, chkbox, type , pName) {
    if ( chkbox.checked ) {
		setCookieWeb(cName, "os");
	}
	if (type == "1") {
		document.getElementById(pName).style.display = "none";
		document.getElementById(cName).style.visibility = "hidden";
	} else {
		window.close();
	}
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