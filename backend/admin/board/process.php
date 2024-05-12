<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$board = new Board($pageRows, $tablename, $_REQUEST, 'brd_id');

$_POST = xss_clean($_POST);

$cmd = $_POST['cmd'];
if($_POST['brd_id']){
	$no = $_POST['brd_id'];
}

$updatedata = array(
	'brd_title' => $_POST['brd_title'],						   // 게시판 제목
	'brd_code' => $_POST['brd_code'], 						   // 게시판 코드
	'brd_file' => $_POST['brd_file'] ? $_POST['brd_file'] : 0, // 첨부파일 사용
	'brd_filecnt' => $_POST['brd_filecnt'], 				   // 첨부파일 개수
	'brd_link' => $_POST['brd_link'] ? $_POST['brd_link'] : 0, // 관련링크 사용
	'brd_linkcnt' => $_POST['brd_linkcnt'], 				   // 관련링크 개수
	'brd_newdate' => $_POST['brd_newdate'] 					   // new아이콘 보이기
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

		$updatedata['brd_datetime'] = date('Y-m-d H:i:s');
		$updatedata['brd_delyn'] = 'N';
        
        $r = $board->insert($updatedata);

        if ($r > 0) {
            echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 등록되었습니다.');
        } else {
            echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
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
		$updatedata['brd_updatetime'] = date('Y-m-d H:i:s');

		$r = $board->update($no, $updatedata);

		if ($r > 0) {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 수정되었습니다.');
		} else {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
		}
	
	} else if ($cmd == 'GROUPDELETE') {

		$chk = $_REQUEST['chk'];
		
		$r = 0;
		for ($i=0; $i<count($chk); $i++) {
			$r += $board->delete($chk[$i], $_REQUEST);
		}
		if ($r > 0) {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 삭제되었습니다.');
		} else {
			echo returnURLMsg($board->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}

	} else if ($cmd == 'delete') {
		
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