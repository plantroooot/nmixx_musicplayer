<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Popup.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$popup = new Popup($pageRows, $tablename, $_REQUEST, $primary_key);
$_POST = xss_clean($_POST);

$cmd = $_POST['cmd'];
if($_POST['pop_id']){
	$no = $_POST['pop_id'];
}

$pop_activated = isset($_POST['pop_activated']) ? $_POST['pop_activated'] : 'N';
$pop_title = isset($_POST['pop_title']) ? $_POST['pop_title'] : null;
$pop_start_day = isset($_POST['pop_start_day']) ? $_POST['pop_start_day'] : null;
$pop_end_day = isset($_POST['pop_end_day']) ? $_POST['pop_end_day'] : null;
$pop_center_yn = isset($_POST['pop_center_yn']) ? $_POST['pop_center_yn'] : 'N';
$pop_area_left = isset($_POST['pop_area_left']) ? $_POST['pop_area_left'] : 0;
$pop_area_top = isset($_POST['pop_area_top']) ? $_POST['pop_area_top'] : 0;
$pop_relation_url = isset($_POST['pop_relation_url']) ? $_POST['pop_relation_url'] : null;

$updatedata = array(
	'pop_activated' => $pop_activated,
	'pop_title' => $pop_title,
	'pop_start_day' => $pop_start_day,
	'pop_end_day' => $pop_end_day,
	'pop_center_yn' => $pop_center_yn,
	'pop_area_left' => $pop_area_left,
	'pop_area_top' => $pop_area_top,
	'pop_relation_url' => $pop_relation_url
);

// 파일첨부

// 기존 파일삭제시
if(isset($_POST['pop_imagename_chk'])){
	$updatedata['pop_imagename'] = null;
	$updatedata['pop_imagename_org'] = null;
}

if($_FILES && $_FILES['pop_imagename']['name']){			
	$_POST = fileupload('pop_imagename', $_SERVER['DOCUMENT_ROOT'].$uploadPath, $_POST, false, $maxSaveSize);		// 이미지

	$updatedata['pop_imagename'] = $_POST['pop_imagename'];
	$updatedata['pop_imagename_org'] = $_POST['pop_imagename_org'];
}

?>
<!doctype html>
<html lang="ko">
<head>
<? include $_SERVER['DOCUMENT_ROOT']."/admin/include/headHtml.php" ?>
</head>
<body>
<?php

if (checkReferer($_SERVER["HTTP_REFERER"])) {
	
	if ($cmd == 'WRITE') {

		$updatedata['pop_datetime'] = date('Y-m-d H:i:s');
		$updatedata['pop_delyn'] = 'N';
        
        $r = $popup->insert($updatedata);

        if ($r > 0) {
            echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 등록되었습니다.');
        } else {
            echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
        }
		

	} else if ($cmd == 'EDIT') {

		// $n = $spam->checkWords($_REQUEST);
		// if($n > 0){
		// 	echo "<script>alert('부적절한 단어가 존재합니다.'); history.back();</script>";
		// }else{

		// 	$_POST = xss_clean($_POST);

		// 	if(isset($_POST['custom_board']) && $_POST['custom_board'] != ""){
		// 		$_POST['user_board'] = $_POST['custom_board'];
		// 	}

		// }

		$r = $popup->update($no, $updatedata);

		if ($r > 0) {
			echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 수정되었습니다.');
		} else {
			echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
		}
	
	} else if ($cmd == 'GROUPDELETE') {

		$chk = $_REQUEST['chk'];
		
		$r = 0;
		for ($i=0; $i<count($chk); $i++) {
			$r += $popup->delete($chk[$i], $_REQUEST);
		}
		if ($r > 0) {
			echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 삭제되었습니다.');
		} else {
			echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}

	} else if ($cmd == 'delete') {
		
		$r = $popup->delete($no);

		if ($r > 0) {
			echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '정상적으로 삭제되었습니다.');
		} else {
			echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}
	}
	

} else {
	echo returnURLMsg($popup->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
}
?>
</body>
</html>