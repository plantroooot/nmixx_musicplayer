<?
	$pageViewTitle		= "게시글 상세";
	$pageWriteTitle		= "게시글 등록";
	$pageEditTitle		= "게시글 수정";
	$tablename			= "post";
	$pageRows			= 10;
	$primary_key		= "post_id";
	$uploadPath			= "/upload/post/";			// 파일, 동영상 첨부 경로
	
	$maxSaveSize		= 50*1024*1024;					// 50Mb
	$userCon			= false;
	$isComment			= false;							// 댓글 사용여부
	$useFile  			= false;							// 파일 첨부 [사용: true, 사용 안함 : false]
	$useMovie  	 		= false;							// 파일 첨부 [사용: true, 사용 안함 : false]
	$useRelationurl		= false;							// 관련URL 첨부 [사용: true, 사용 안함 : false]
	$useMain			= false;							//메인 노출 사용

	if (isset($_REQUEST['pageRows'])) $pageRows = $_REQUEST['pageRows'];
?>