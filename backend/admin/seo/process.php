<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/seo/Seo.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$seo = new Seo($pageRows, $tablename, $_REQUEST, $primary_key);

$_POST = xss_clean($_POST);

$cmd = $_POST['cmd'];

$seo_name = isset($_POST['seo_name']) ? $_POST['seo_name'] : null;              // 메뉴명
$seo_name_en = isset($_POST['seo_name_en']) ? $_POST['seo_name_en'] : null;     // 메뉴명(영문)
$seo_url = isset($_POST['seo_url']) ? $_POST['seo_url'] : null;                 // 링크주소
$seo_order = isset($_POST['seo_order']) ? $_POST['seo_order'] : 1;              // 순서
$seo_is_blank = isset($_POST['seo_is_blank']) ? $_POST['seo_is_blank'] : 'N';   // 새창여부
$seo_activated = isset($_POST['seo_activated']) ? $_POST['seo_activated'] : 'N';// 노출여부
$seo_parent = isset($_POST['seo_parent']) ? $_POST['seo_parent'] : 0;           // 상위메뉴 PK
$seo_depth = isset($_POST['seo_depth']) ? $_POST['seo_depth'] : 1;           // depth

$updatedata = array(
	'seo_name' => $seo_name,
	'seo_name_en' => $seo_name_en,
	'seo_url' => $seo_url,
	'seo_order' => $seo_order,
	'seo_is_blank' => $seo_is_blank,
	'seo_activated' => $seo_activated,
	'seo_parent' => $seo_parent,
	'seo_depth' => $seo_depth
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

		$updatedata['seo_datetime'] = date('Y-m-d H:i:s');
        
        $r = $seo->insert($updatedata);

        if ($r > 0) {
            echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 등록되었습니다.');
        } else {
            echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
        }
		

	} else if ($cmd == 'EDIT') {

        
        $chk = $_POST['chk'];

		$r = 0;
		for ($i=0; $i<count($chk); $i++) {

            $updatedata = array(
                'seo_name' => $seo_name[$chk[$i]],
                'seo_name_en' => $seo_name_en[$chk[$i]],
                'seo_url' => $seo_url[$chk[$i]],
                'seo_order' => $seo_order[$chk[$i]],
                'seo_is_blank' => $seo_is_blank[$chk[$i]],
                'seo_activated' => $seo_activated[$chk[$i]]
            );
            
            $r += $seo->update($chk[$i], $updatedata);
		}

		$updatedata['post_updatetime'] = date('Y-m-d H:i:s');

		if ($r > 0) {
			echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 수정되었습니다.');
		} else {
			echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
		}
	
	} else if ($cmd == 'GROUPDELETE') {

		$chk = $_REQUEST['chk'];
		
		$r = 0;
		for ($i=0; $i<count($chk); $i++) {
			$r += $seo->delete_complete($chk[$i], $_REQUEST);
		}
		if ($r > 0) {
			echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 삭제되었습니다.');
		} else {
			echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}

	} else if ($cmd == 'delete') {
		
		$r = $seo->delete_complete($no);

		if ($r > 0) {
			echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '정상적으로 삭제되었습니다.');
		} else {
			echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}
	}
	

} else {
	echo returnURLMsg($seo->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
}
?>
</body>
</html>