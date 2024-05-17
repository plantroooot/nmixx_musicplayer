<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/environment/Admin.class.php";
?>
<!doctype html>
<html lang="ko">
<head>
    <?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/headHtml.php"; ?>
</head>
<body>
<?php
$url = $_REQUEST['url'];
$param = $_REQUEST['param'];

// 파라메터가 있을 경우에는 url 뒷에 결합한다.
if ($param) {
	$url = $url."?".$param;
} else {
	$url = START_PAGE;
}
$_POST = xss_clean($_POST);

$admin = new Admin(0, "admin", $_POST);
$result = $admin->loginCheck($_POST);

if($result){
	$row = mysqli_fetch_array($result);
	$loginCheck = $row['cnt'];
}else{
	$loginCheck = 0;
}

if ($loginCheck > 0) {
	$result = $admin->getLoginSessionInfo($_POST);
	$row = mysqli_fetch_array($result);

	$_SESSION['admin_no'] = $row['adm_id'];
	$_SESSION['admin_id'] = $row['adm_userid'];
	$_SESSION['admin_name'] = $row['adm_username'];
	$_SESSION['admin_grade'] = $row['adm_grade'];
	$_SESSION['admin_email'] = $row['adm_email'];
	
	$admin->insertLoginHistory($row['adm_userid'], $row['adm_username'], $_SERVER['REMOTE_ADDR']);
	
	$url = START_PAGE;
?>
<form name="frm" id="frm" method="post" action="<?=COMPANY_URL2."/admin/include/login_ajax.php" ?>" target="ifrm">
<input type="hidden" name="id" value="<?=$_REQUEST['id'] ?>"/>
<input type="hidden" name="password" value="<?=$_REQUEST['password'] ?>"/>
<iframe id="ifrm" name="ifrm" width="0" height="0"></iframe>
	<script>
		$("#frm").submit();
		location.href='<?=$url?>';
	</script>
    <?php
} else {
	echo returnHistory("아이디 비밀번호를 확인해주세요.");
}

?>

</body>
</html>