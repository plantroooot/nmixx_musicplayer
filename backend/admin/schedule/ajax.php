<?session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";

include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Schedule.class.php"; 
include "config.php";

$schedule = new Schedule($pageRows, $tablename, $_REQUEST, $primary_key);

$cmd = $_POST['cmd'];
if($_POST[$primary_key]){
	$no = $_POST[$primary_key];
}
$sche_nmem = isset($_POST['sche_nmem']) ? implode(',', $_POST['sche_nmem']) : null;              // 링크주소
$sche_date = isset($_POST['sche_date']) ? $_POST['sche_date'] : date('Y-m-d H:i:00');              // SNS타입
$sche_target = isset($_POST['sche_target']) ? $_POST['sche_target'] : 1;           // 순서
$sche_type = isset($_POST['sche_type']) ? $_POST['sche_type'] : 1;           // 순서
$sche_contents = isset($_POST['sche_contents']) ? $_POST['sche_contents'] : null;     		 // 비고

$updatedata = array(
	'sche_nmem' => $sche_nmem,
	'sche_date' => $sche_date,
	'sche_target' => $sche_target,
	'sche_type' => $sche_type,
	'sche_contents' => $sche_contents
);

if (checkReferer($_SERVER["HTTP_REFERER"])) {

    if($cmd == 'WRITE'){

        $updatedata['sche_datetime'] = date('Y-m-d H:i:s');
		$updatedata['sche_delyn'] = 'N';

        $r = $schedule->insert($updatedata);

    } else if ($cmd = 'EDIT'){       

		$r = $schedule->update($no, $updatedata);    
            
    }

    if($r > 0){
        echo 'success';
    }else{
        echo 'fail';
    }

}else{
	echo "fail2";
}
?>