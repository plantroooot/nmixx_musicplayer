
<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php";
include $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";

$loginCheck = false;

if (isset($_SESSION['admin_id'])) {
	$loginCheck = true;
}

$_SESSION['param']='';
$_SESSION['url']='';
if (!$loginCheck) {
	$url = $_SESSION['url'];
	if (!$url) $url = START_PAGE;
	$param = $_SESSION['param'];
?>

<!doctype html>
<html lang="ko">
<head>
    <?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/headHtml.php"; ?>


<script>
function loginCheck(){
	if ( getObject("id").value.length < 1 ) {
		alert("아이디를 입력해주세요.");
		getObject("id").focus();

		return false;
	}
	if ( getObject("password").value.length < 1 ) {
		alert("비밀번호를 입력해주세요.");
		getObject("password").focus();
		return false;
	}
	var f = document.board;
	if (f.reg.checked==true) {
		var h = CryptoJS.AES.encrypt(f.id.value, "<?=REFERER_URL?>");
	   document.cookie = "cookie_adminid=" + h + ";path=/;expires=Sat, 31 Dec 2050 23:59:59 GMT;";
	} else {
	   var now = new Date();	
	   document.cookie = "cookie_adminid=" + f.id.value + ";path=/;expires="+now.getTime();
	}
	return true;
}

function userid_chk() {
	var f=document.flogin;
	var useridname = CookieVal("cookie_adminid");
	
	if (useridname=="null"){	
		f.login_id.focus();
		f.login_id.value="";
	} else {
		f.password.focus();
		var h = CryptoJS.AES.decrypt( useridname, "<?=REFERER_URL?>" );
		h = h.toString(CryptoJS.enc.Utf8);

		f.login_id.value=h;
		f.reg.checked=true;
	}
}

function CookieVal(cookieName) {
	thisCookie = document.cookie.split("; ");
	for (var i = 0; i < thisCookie.length;i++) {
		if (cookieName == thisCookie[i].split("=")[0]) {
			return thisCookie[i].split("=")[1];
		}
	}
	return "null" ;
}
//-->
function labelChk(){
	if($('#id_save').is(':checked')){
		$('.id_save label').removeClass('beforebg');
	}else{
		$('.id_save label').addClass('beforebg');
	}
}
$(function(){
	userid_chk();
	
	if($('#id_save').is(':checked')){
		$('.id_save label').addClass('beforebg');
	}else{
		$('.id_save label').removeClass('beforebg');
	}
});
</script>
</head>
<body onload="$('#id').focus();">
    <div id="mb_login" class="mbskin">
        <h1><?=COMPANY_NAME?> 관리자모드</h1>

        <form name="flogin" action="/admin/include/login.php" method="post" id="flogin">
				<input type="hidden" name="url" id="url"/>
				<input type="hidden" name="param" id="param"/>
            <fieldset id="login_fs">
                <legend>관리자 로그인</legend>
                <div id="login_frm">
                    <label for="login_id" class="sound_only">아이디<strong class="sound_only"> 필수</strong></label>
                    <input type="text" name="mb_id" id="login_id" placeholder="아이디" required class="frm_input required" maxLength="20">
                    <label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
                    <input type="password" name="mb_password" id="login_pw" placeholder="비밀번호" required class="frm_input required" maxLength="20">
                    
                    <button type="submit" class="btn_submit">로그인</button>
                    <div id="login_info" class="chk_box">
                        <div class="login_if_auto chk_box">
                            <input type="checkbox" name="auto_login" id="login_auto_login" class="selec_chk">
                            <label for="login_auto_login"><span></span> 자동로그인</label>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    } else {
        echo "<script>location.href='".START_PAGE."';</script>";
    }
?>