<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "../post/config.php";

/*
| ----------------------------------------------------------------------------------------
| 게시글 리스트
| ----------------------------------------------------------------------------------------
*/
$pageTitle = '진행중인 투표';
$post = new Post($pageRows, $tablename, $_REQUEST);
$rowPageCount = $post->getCount($_REQUEST);
$result = $post->getList($_REQUEST);
$colspan = 7;

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
                        <col width="80px" />
                        <col width="200px" />
                        <col width="*" />
                        <col width="200px" />
                        <col width="150px" />
                        <col width="115px" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="chkall" class="sound_only">게시글 전체</label>
                                <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                            </th>
                            <th scope="col">번호</th>
                            <th scope="col">제목</th>
                            <th scope="col">내용</th>
                            <th scope="col">투표기간</th>
                            <th scope="col">작성일</th>
                            <th scope="col">관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            if($result){
                                foreach($result as $key => $row){
                                    $targetUrl = "style='cursor:pointer;' onclick=\"location.href='".$post->getQueryString('view.php', $row['post_id'], $_REQUEST)."'\"";
                        ?>      
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $key; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row['post_id']; ?>" id="chk_<?php echo $key ?>" data-num="<?php echo $row['data_cnt']; ?>" >
                            </td>
                            <td <?php echo $targetUrl; ?>><?php echo $rowPageCount[0] - (($post->reqPageNo-1)*$pageRows) - $key?></td>
                            <td <?php echo $targetUrl; ?>><?php echo $row['post_title']?></td>
                            <td <?php echo $targetUrl; ?> class="txt_l"><?php echo $row['post_contents']?></td>
                            <td <?php echo $targetUrl; ?>><?php echo getYMD($row['post_startdate'])?> ~ <?php echo getYMD($row['post_enddate'])?></td>
                            <td <?php echo $targetUrl; ?>><?php echo $row['post_datetime']?></td>
                            <td>
                                <div class="btnSet mt0">
                                    <a href="<?=$post->getQueryString('write.php', $row['post_id'], $_REQUEST)?>" class="btn btn_03">수정</a>                                    
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
			<input type="hidden" name="bcode" id="bcode" value="<?php echo $_REQUEST['bcode']; ?>"/> 
        </form>
        <div class="btn_fixed_top">
            <?php if ($_SESSION['admin_grade'] == 0) { ?>
                <input type="submit" name="act_button" value="선택삭제" onclick="groupDelete();" class="btn_02 btn">
                <a href="write.php?bcode=<?=$_REQUEST['bcode']?>" id="bo_add" class="btn_01 btn">게시글 등록</a>
            <?php } ?>
        </div>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>