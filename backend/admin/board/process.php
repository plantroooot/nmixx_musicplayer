<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$board = new Board($pageRows, $tablename, $_REQUEST);

?>
<!doctype html>
<html lang="ko">
<head>
<? include $_SERVER['DOCUMENT_ROOT']."/admin/include/headHtml.php" ?>
</head>
<body>
<?php

if (checkReferer($_SERVER["HTTP_REFERER"])) {
	
	if ($_REQUEST['cmd'] == 'WRITE') {

        $_POST = xss_clean($_POST);
        
        $r = $board->insert($_POST);


        if ($r > 0) {
            echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 등록되었습니다.');
        } else {
            echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
        }
		

	} else if ($_REQUEST['cmd'] == 'edit') {

		$n = $spam->checkWords($_REQUEST);
		if($n > 0){
			echo "<script>alert('부적절한 단어가 존재합니다.'); history.back();</script>";
		}else{

			$_POST = xss_clean($_POST);

			if(isset($_POST['custom_board']) && $_POST['custom_board'] != ""){
				$_POST['user_board'] = $_POST['custom_board'];
			}

			$r = $board->update($_POST);

			if ($r > 0) {
				echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 수정되었습니다.');
			} else {
				echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
			}
		}
	
	} else if ($_REQUEST['cmd'] == 'groupDelete') {

		$no = $_REQUEST['chk'];
		
		$r = 0;
		for ($i=0; $i<count($no); $i++) {
			$r += $board->delete($no[$i], $_REQUEST);
		}

		if ($r > 0) {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 삭제되었습니다.');
		} else {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}

	} else if ($_REQUEST['cmd'] == 'delete') {

		$no = $_REQUEST['no'];
		
		$r = $board->delete($no);

		if ($r > 0) {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '정상적으로 삭제되었습니다.');
		} else {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}
	}
	

} else {
	echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
}
?>
</body>
</html>