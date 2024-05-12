<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$post = new Post($pageRows, $tablename, $_REQUEST, $primary_key);

$board = new Board($pageRows, 'board', $_REQUEST);
$brd_data = $board->getBoardData($_POST['bcode'], false);


$_POST = xss_clean($_POST);

$cmd = $_POST['cmd'];
if($_POST['brd_id']){
	$no = $_POST['brd_id'];
}

$post_title = isset($_POST['post_title']) ? $_POST['post_title'] : null; // 게시글 제목(국문)
$post_title_en = isset($_POST['post_title_en']) ? $_POST['post_title_en'] : null;
$post_contents = isset($_POST['post_contents']) ? $_POST['post_contents'] : null;
$post_contents_en = isset($_POST['post_contents_en']) ? $_POST['post_contents_en'] : null;
$post_links = isset($_POST['post_link']) ? json_encode($_POST['post_link'], JSON_UNESCAPED_UNICODE) : '';
$post_files = isset($_POST['post_file']) ? json_encode($_POST['post_file'], JSON_UNESCAPED_UNICODE) : '';
$post_imageinfo = isset($_POST['post_imageinfo']) ? json_encode($_POST['post_imageinfo'], JSON_UNESCAPED_UNICODE) : '';
$post_categoryfk = isset($_POST['post_categoryfk']) ? $_POST['post_categoryfk'] : null;
$post_top = isset($_POST['post_top']) ? $_POST['post_top'] : 0;
$post_readno = isset($_POST['post_readno']) ? $_POST['post_readno'] : 0;
$post_startdate = isset($_POST['post_startdate']) ? $_POST['post_startdate'] : null;
$post_enddate = isset($_POST['post_enddate']) ? $_POST['post_enddate'] : null;

$updatedata = array(
	'post_title' => $post_title,
	'post_title_en' => $post_title_en,
	'post_contents' => $post_contents,
	'post_contents_en' => $post_contents_en,
	'post_links' => $post_links,
	'post_files' => $post_files,
	'post_imageinfo' => $post_imageinfo,
	'post_categoryfk' => $post_categoryfk,
	'post_top' => $post_top,
	'post_readno' => $post_readno,
	'post_startdate' => $post_startdate,
	'post_enddate' => $post_enddate
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

		$updatedata['brd_id'] = $_POST['brd_id'];
		$updatedata['brd_code'] = $_POST['brd_code'];
		$updatedata['post_datetime'] = date('Y-m-d H:i:s');
		$updatedata['post_delyn'] = 'N';
        
        $r = $post->insert($updatedata);

        if ($r > 0) {
            echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 등록되었습니다.');
        } else {
            echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
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
		$updatedata['post_updatetime'] = date('Y-m-d H:i:s');

		$r = $post->update($no, $updatedata);

		if ($r > 0) {
			echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '정상적으로 수정되었습니다.');
		} else {
			echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_POST), '요청처리중 장애가 발생하였습니다.');
		}
	
	} else if ($cmd == 'GROUPDELETE') {

		$chk = $_REQUEST['chk'];
		
		$r = 0;
		for ($i=0; $i<count($chk); $i++) {
			$r += $post->delete($chk[$i], $_REQUEST);
		}
		if ($r > 0) {
			echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '총 '.$r.'건이 삭제되었습니다.');
		} else {
			echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}

	} else if ($cmd == 'delete') {
		
		$r = $post->delete($no);

		if ($r > 0) {
			echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '정상적으로 삭제되었습니다.');
		} else {
			echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
		}
	}
	

} else {
	echo returnURLMsg($post->getQueryString(getRemoviSslUrl($_SERVER["REQUEST_URI"], 'index.php'), 0, $_REQUEST), '요청처리중 장애가 발생하였습니다.');
}
?>
</body>
</html>