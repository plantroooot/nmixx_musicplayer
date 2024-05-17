<?
	$pageTitle			= "게시판관리";
	$pageWriteTitle		= "게시판 생성";
	$pageEditTitle		= "게시판 수정";
	$tablename			= "board";
	$pageRows			= 10;
	$uploadPath			= "/upload/board/";			// 파일, 동영상 첨부 경로
	
	$maxSaveSize		= 50*1024*1024;					// 50Mb
	$userCon			= false;
	$isComment			= false;							// 댓글 사용여부
	$useFile  			= false;							// 파일 첨부 [사용: true, 사용 안함 : false]
	$useMovie  	 		= false;							// 파일 첨부 [사용: true, 사용 안함 : false]
	$useRelationurl		= false;							// 관련URL 첨부 [사용: true, 사용 안함 : false]
	$useMain			= false;							//메인 노출 사용

	if (isset($_REQUEST['pageRows'])) $pageRows = $_REQUEST['pageRows'];
?>