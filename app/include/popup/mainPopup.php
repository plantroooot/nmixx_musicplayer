<?

include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Popup.class.php";

$popup = new Popup(9999, 'popup', $_REQUEST);
$pop_rowPageCount = $popup->getCount($_REQUEST);
$pop_result = $popup->getList($_REQUEST);

for($i = 0; $i < count($pop_result); $i++) {
	$row = $pop_result[$i];

    if( ! array_key_exists('divPop'.$row['pop_id'], $_COOKIE) ) {
        $pop_url = $row['pop_relation_url'] ? "style='cursor:grab;' onclick=\"window.open('".$row['pop_relation_url']."')\"" : 'style="cursor:grab;"';
        
        $pop_position = $row['pop_center_yn'] == 'Y' ? 'left:50%;top:50%;transform:translate(-50%,-50%);' : 'left:'.$row['pop_area_left'].'px;top:'.$row['pop_area_top'].'px;';
?>
	<div id="showimage<?=$row['pop_id']?>" style="position:absolute;<?php echo $pop_position; ?>z-index:999999;">
		<div id="divPop<?=$row['pop_id']?>">
			<div id="dragbar<?=$row['pop_id']?>" <?php echo $pop_url; ?>>
				<div id="popMain<?=$row['pop_id']?>">
                    <img src="/upload/popup/<?php echo $row['pop_imagename']; ?>" alt="<?=$row['pop_title']?>" style="max-width: 600px;">
                </div>
			</div>
			<div style="background:#000000; color:#fff; vertical-align:middle;font-size:0; text-align:center;">
                <a href="javascript:;" onclick="closeLayer('divPop<?=$row['pop_id']?>', 1, 'showimage<?=$row['pop_id']?>');" style="padding: 15px; display: inline-block; width: 50%; font-size: 15px; color: #fff; box-sizing: border-box;">오늘 하루 이 창을 열지 않음</a>
				<a href="javascript:;" onclick="closeLayer('divPop<?=$row['pop_id']?>', 0, 'showimage<?=$row['pop_id']?>');" style="padding: 15px; display: inline-block; width: 50%; font-size: 15px; color: #fff; border-left: 1px solid #fff; box-sizing: border-box; box-sizing: border-box;">닫기</a>
			</div>
		</div>
	</div>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
    $( function() {
        $( "#showimage<?=$row['pop_id']?>" ).draggable();
    } );
    </script>						
<?  
    }
}
?>