<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

/*
| ----------------------------------------------------------------------------------------
| 게시판 리스트
| ----------------------------------------------------------------------------------------
*/

$board = new Board($pageRows, $tablename, $_REQUEST);
$rowPageCount = $board->getCount($_REQUEST);
$result = $board->getList($_REQUEST);

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';
$colspan = 9;

?>
<script>

function groupDelete() {	
	if ( $('input:checkbox[name="chk[]"]:checked').length > 0 ){

		if (confirm("선택한 항목을 삭제하시겠습니까?")) {
			let checkedBox = $('input:checkbox[name="chk[]"]:checked');
			let data_cnt = 0;

			for(let i = 0; i < checkedBox.length; i++){
				data_cnt += parseInt(checkedBox[i].dataset.num);
			}
			
			if(data_cnt == 0){
				$('input#cmd').val('groupDelete');
				document.fboardlist.submit();
			}else{
				alert('남아있는 게시글이 있는경우 삭제할 수 없습니다.\n게시글을 모두 삭제해주세요.')
			}
		}
	} else {
		alert("삭제할 항목을 하나 이상 선택해 주세요.");
	}
}

</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageTitle?></h1>
    <div class="container_wr">
        <div class="local_ov01 local_ov">
            <?php echo $listall ?>
            <span class="btn_ov01">
                <span class="ov_txt">생성된 게시판수</span>
                <span class="ov_num"><?php echo $rowPageCount[0]; ?> 개</span>
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
                        <col width="200px" />
                        <col width="200px" />
                        <col width="200px" />
                        <col width="14%" />
                        <col width="7%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="chkall" class="sound_only">게시판 전체</label>
                                <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                            </th>
                            <th scope="col">번호</th>
                            <th scope="col">게시판 이름</th>
                            <th scope="col">첨부파일</th>
                            <th scope="col">관련링크</th>
                            <th scope="col">작성일</th>
                            <th scope="col">관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            if($result){
                                foreach($result as $key => $row){
                            }
                        
                        ?>      
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $key; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row['brd_id']; ?>" id="chk_<?php echo $key ?>" data-num="<?php echo $row['data_cnt']; ?>" >
                            </td>
                            <td><?php echo $rowPageCount[0] - (($board->reqPageNo-1)*$pageRows) - $key?></td>
                            <td><?php echo $row['brd_title']?></td>
                            <td>
                                <?if($row['brd_file'] == 1){?>
                                    <span>사용(<?php echo $row['brd_filecnt'] ?>)</span>
                                <?}else{?>
                                    <span>미사용</span>
                                <?}?>
                            </td>
                            <td>
                                <?if($row['brd_link'] == 1){?>
                                    <span>사용(<?php echo $row['brd_linkcnt'] ?>)</span>
                                <?}else{?>
                                    <span>미사용</span>
                                <?}?>
                            </td>
                            <td><?php echo $row['brd_datetime']?></td>
                            <td>
                                <div class="btnSet mt0">
                                    <a href="<?=$board->getQueryString('write.php', $row['brd_id'], $_REQUEST)?>" class="btn btn_03">수정</a>                                    
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                            if(!$result){
                                echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>   
			<input type="hidden" name="cmd" id="cmd" value="groupDelete"/> 
        </form>
        <div class="btn_fixed_top">
            <?php if ($_SESSION['admin_grade'] == 0) { ?>
                <input type="submit" name="act_button" value="선택삭제" onclick="groupDelete();" class="btn_02 btn">
                <a href="./write.php" id="bo_add" class="btn_01 btn">게시판 추가</a>
            <?php } ?>
        </div>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>