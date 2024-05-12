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

function setEditor(holder){
	var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: holder,
		sSkinURI: "/smarteditor/SmartEditor2Skin.html",	
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
			fOnBeforeUnload : function(){
				//alert("아싸!");	
			}
		}, //boolean
		fOnAppLoad : function(){
			//예제 코드
			//oEditors.getById["contents"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
		},
		fCreator: "createSEditor2"
	});
	
	return oEditors;
}