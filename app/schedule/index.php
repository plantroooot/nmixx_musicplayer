<?php include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php"; ?>
<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Schedule.class.php";

    /*
    | ----------------------------------------------------------------------------------------
    | 스케줄 리스트
    | ----------------------------------------------------------------------------------------
    */
    $schedule = new Schedule(999999, 'schedule', $_REQUEST, 'sche_id');
    $rowPageCount = $schedule->getCount($_REQUEST);
    $result = $schedule->getList($_REQUEST);

    $rowPageNoDateCount = $schedule->getCount2($_REQUEST);
    $result2 = $schedule->getList2($_REQUEST);
    
    include_once $_SERVER['DOCUMENT_ROOT']."/header.php";

    if(MobileCheck() > 0){
        include_once $_SERVER['DOCUMENT_ROOT']."/schedule/schedule_mo.php";
    }else{
        include_once $_SERVER['DOCUMENT_ROOT']."/schedule/schedule_pc.php";
    }
?>
<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
?>