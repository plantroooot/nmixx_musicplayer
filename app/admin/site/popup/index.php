<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Popup.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

/*
| ----------------------------------------------------------------------------------------
| 게시글 리스트
| ----------------------------------------------------------------------------------------
*/
$pageTitle = '팝업관리';
$popup = new Popup($pageRows, $tablename, $_REQUEST);
$rowPageCount = $popup->getCount($_REQUEST);
$result = $popup->getList($_REQUEST);
$colspan = 5;
include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<script>

function groupDelete() {	
	if ( $('input:checkbox[name="chk[]"]:checked').length > 0 ){

		if (confirm("선택한 항목을 삭제하시겠습니까?")) {			
            $('input#cmd').val('GROUPDELETE');
			document.fboardlist.submit();
		}
        
	} else {
		alert("삭제할 항목을 하나 이상 선택해 주세요.");
	}
}

function ShowDiv(road, pop_up, left, top, is_center) {
	$("#"+road).show();

    if(is_center == 'Y'){
        $('#'+road).css({
            'top' : '50%',
            'left' : '50%',
            'transform' : 'translate(-50%, -50%);'
        });
    }else{
        $('#'+road).css({
            'top' : top,
            'left' : left
        });
    }
    $("#"+pop_up).css('visibility', 'visible')
}

</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageTitle?></h1>
    <div class="container_wr">
        <div class="local_ov01 local_ov">
            <span class="btn_ov01">
                <span class="ov_txt">전체</span>
                <span class="ov_num"><?php echo $rowPageCount[0]; ?>개</span>
            </span>
        </div>        
        <!-- <form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <option value="bo_table">TABLE</option>
                <option value="bo_subject">제목</option>
                <option value="a.gr_id">그룹ID</option>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
            <input type="submit" value="검색" class="btn_submit">
        </form> -->
        <form name="fboardlist" id="fboardlist" action="process.php" method="post">
            <div class="tbl_head01 tbl_wrap">
                <table>
                    <caption><?php echo $pageTitle?> 목록</caption>
                    <colgroup>
                        <col width="42px" />
						<col width="5%" />
						<col width="*" />
						<col width="20%" />
						<col width="15%" />
						<col width="15%" />
						<col width="10%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="chkall" class="sound_only">게시글 전체</label>
                                <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                            </th>
                            <th scope="col">번호</th>
                            <th scope="col">제목</th> 
                            <th scope="col">시작일시</th> 
                            <th scope="col">종료일시</th> 
                            <th scope="col">팝업확인</th>
                            <th scope="col">관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            if($result){
                                foreach($result as $key => $row){
                                    $targetUrl = "style='cursor:pointer;' onclick=\"location.href='".$popup->getQueryString('write.php', $row['pop_id'], $_REQUEST)."'\"";
                        ?>      
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $key; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row['pop_id']; ?>" id="chk_<?php echo $key ?>" data-num="<?php echo $row['data_cnt']; ?>" >
                            </td>
                            <td <?php echo $targetUrl; ?>><?php echo $rowPageCount[0] - (($popup->reqPageNo-1)*$pageRows) - $key?></td>
                            <td <?php echo $targetUrl; ?>><?php echo $row['pop_title']?></td>
                            <td <?php echo $targetUrl; ?>><?php echo getYMD($row['pop_start_day']) ?></td>
                            <td <?php echo $targetUrl; ?>><?php echo getYMD($row['pop_end_day']) ?></td>
                            <td>                                
							    <button type="button" class="btn hoverbg" onclick="ShowDiv('showimage<?=$row['pop_id']?>', 'divPop<?=$row['pop_id']?>', <?=$row['pop_area_left']?>, <?=$row['pop_area_top']?>, '<?=$row['pop_center_yn']?>');">팝업확인</button>
                            </td>
                            <td>
                                <div class="btnSet mt0">
                                    <a href="<?=$popup->getQueryString('write.php', $row['pop_id'], $_REQUEST)?>" class="btn btn_03">수정</a>                                    
                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                            if(!$result){
                                echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>   
			<input type="hidden" name="cmd" id="cmd" value="GROUPDELETE"/> 
        </form>
        <div class="btn_fixed_top">
            <?php if ($_SESSION['admin_grade'] == 0) { ?>
                <input type="submit" name="act_button" value="선택삭제" onclick="groupDelete();" class="btn_02 btn">
                <a href="write.php" id="bo_add" class="btn_01 btn">게시글 등록</a>
            <?php } ?>
        </div>
    </div>
</div>
<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>
<script src="/admin/site/popup/popup.js"></script>
<?
for($i = 0; $i < count($result); $i++) {
	$row = $result[$i];
    $pop_url = $row['pop_relation_url'] ? "style='cursor:pointer;' onclick=\"window.open('".$row['pop_relation_url']."')\"" : '';
    
    $pop_position = $row['pop_center_yn'] == 'Y' ? 'left:50%;top:50%;transform:translate(-50%,-50%);' : 'left:'.$row['pop_area_left'].'px;top:'.$row['pop_area_top'].'px;';







?>
	<div id="showimage<?=$row['pop_id']?>" style="position:absolute;<?php echo $pop_position; ?>z-index:999999;display:none;">
		<div id="divPop<?=$row['pop_id']?>">
			<div id="dragbar<?=$row['pop_id']?>" <?php echo $pop_url; ?>>
				<div id="popMain<?=$row['pop_id']?>">
                    <img src="/upload/popup/<?php echo $row['pop_imagename']; ?>" alt="<?=$row['pop_title']?>">
                </div>
			</div>
			<div style="background:#000000; color:#fff; vertical-align:middle;font-size:0; text-align:center;">
                <a href="javascript:;" onclick="closeLayer('divPop<?=$row['pop_id']?>', this, '1', 'showimage<?=$row['pop_id']?>');" style="padding: 15px; display: inline-block; width: 50%; font-size: 15px; color: #fff;">오늘 하루 이 창을 열지 않음</a>
				<a href="javascript:;" onclick="closeLayer('divPop<?=$row['pop_id']?>', 'chkbox<?=$row['pop_id']?>', '1', 'showimage<?=$row['pop_id']?>');" style="padding: 15px; display: inline-block; width: 50%; font-size: 15px; color: #fff; border-left: 1px solid #fff; box-sizing: border-box;">닫기</a>
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
?>