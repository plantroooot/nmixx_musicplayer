<?
	
	$pageTitle 			= '스케줄 관리';
	$pageWriteTitle		= "공식계정 생성";
	$pageEditTitle		= "공식계정 수정";
	$tablename			= "schedule";
	$pageRows			= 999999;
	$primary_key		= "sche_id";
	$uploadPath			= "/upload/schedule/";			// 파일, 동영상 첨부 경로
	
	$maxSaveSize		= 50*1024*1024;					// 50Mb
	$userCon			= false;
	$isComment			= false;							// 댓글 사용여부
	$useFile  			= false;							// 파일 첨부 [사용: true, 사용 안함 : false]
	$useMovie  	 		= false;							// 파일 첨부 [사용: true, 사용 안함 : false]
	$useRelationurl		= false;							// 관련URL 첨부 [사용: true, 사용 안함 : false]
	$useMain			= false;							//메인 노출 사용

	if (isset($_REQUEST['pageRows'])) $pageRows = $_REQUEST['pageRows'];
?>