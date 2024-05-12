function check_all(f)
{
    var chk = document.getElementsByName("chk[]");

    for (i=0; i<chk.length; i++)
        chk[i].checked = f.chkall.checked;
}

// 체크박스가 하나라도 체크되어 있는지 확인
function isSeleted(objCheck){
	var count = 0;
	if ( objCheck ) {
		if(objCheck.name != undefined) {
			if (objCheck.checked ==true) {
				count=1;
			}
		} else {
			for (i=0; i<objCheck.length; i++) {
				if (objCheck[i].checked == true) {
					count=count+1; 
					break;
				}
			}
		}
    }
	if (count==0){
		return false;
	} else {
		return true;
	}
}

// 오직 숫자만
function isOnlyNumber(obj){
	var exp = /[^0-9]/g;
	if ( exp.test(obj.value) ) {
		alert("숫자만 입력가능합니다.");
		obj.value = "";
		obj.focus();
	}
}

//숫자와 하이픈 표시
function isNumberOrHyphen(obj){
	var exp = /[^0-9-]/g;
	if ( exp.test(obj.value) ) {
		alert("숫자와 '-'만 입력가능합니다.");
		obj.value = "";
		obj.focus();
	}
}

function isNumberOrHyphen2(obj){
	var exp = /[^0-9,]/g;
	if ( exp.test(obj.value) ) {
		alert("숫자만 입력가능합니다.");
		obj.value = "";
		obj.focus();
	}
}