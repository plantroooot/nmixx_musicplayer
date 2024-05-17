<?session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/YoutubeViews.class.php";

$youtube_views = new YoutubeViews(999, 'youtube_views', $_REQUEST);
//$result = $youtube_views->getViewsData($_REQUEST['type']);

$r = "";
if (checkReferer($_SERVER["HTTP_REFERER"])) {

	$r = $youtube_views->getViewsData($_REQUEST['type']);

	if($r){
		echo $r;
	}else{
		echo "fail2";
	}
	
}else{
	echo "fail";
}
?>