<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/OfficialInfo.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$official = new OfficialInfo($pageRows, $tablename, $_REQUEST, $primary_key);

$_POST = xss_clean($_POST);

$cmd = $_POST['cmd'];

$ofi_type = isset($_POST['ofi_type']) ? $_POST['ofi_type'] : 1;              // SNS타입
$ofi_url = isset($_POST['ofi_url']) ? $_POST['ofi_url'] : null;              // 링크주소
$ofi_order = isset($_POST['ofi_order']) ? $_POST['ofi_order'] : 1;           // 순서
$ofi_etc = isset($_POST['ofi_etc']) ? $_POST['ofi_etc'] : null;     		 // 비고

$updatedata = array(
	'ofi_type' => $ofi_type,
	'ofi_url' => $ofi_url,
	'ofi_order' => $ofi_order,
	'ofi_etc' => $ofi_etc
);

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

        $r = $official->insert($updatedata);

        if ($r > 0) {
            echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 등록되었습니다.');
        } else {
            echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
        }
		

	} else if ($cmd == 'EDIT') {
        
        $chk = $_POST['chk'];

		$r = 0;
		for ($i=0; $i<count($chk); $i++) {

			$updatedata = array(
				'ofi_type' => $ofi_type[$chk[$i]],
				'ofi_url' => $ofi_url[$chk[$i]],
				'ofi_order' => $ofi_order[$chk[$i]],
				'ofi_etc' => $ofi_etc[$chk[$i]]
			);
            
            $r += $official->update($chk[$i], $updatedata);
		}

		if ($r > 0) {
			echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 수정되었습니다.');
		} else {
			echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
		}
	
	} else if ($cmd == 'GROUPDELETE') {

		$chk = $_REQUEST['chk'];
		
		$r = 0;
		for ($i=0; $i<count($chk); $i++) {
			$r += $official->delete_complete($chk[$i], $_REQUEST);
		}
		if ($r > 0) {
			echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 삭제되었습니다.');
		} else {
			echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}

	} else if ($cmd == 'delete') {
		
		$r = $official->delete_complete($no);

		if ($r > 0) {
			echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '정상적으로 삭제되었습니다.');
		} else {
			echo returnURLMsg($official->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}
	}
	

} else {
	echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
}
?>
</body>
</html>