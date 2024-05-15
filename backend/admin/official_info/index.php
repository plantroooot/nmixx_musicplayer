<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/OfficialInfo.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

/*
| ----------------------------------------------------------------------------------------
| 공식계정 리스트
| ----------------------------------------------------------------------------------------
*/
$pageTitle = '공식계정 관리';
$official = new OfficialInfo($pageRows, $tablename, $_REQUEST, $primary_key);
$rowPageCount = $official->getCount($_REQUEST);
$result = $official->getList($_REQUEST);
$colspan = 3;

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<script>

function groupEdit() {	
	if ( $('input:checkbox[name="chk[]"]:checked').length > 0 ){

		if (confirm("선택한 항목을 수정하시겠습니까?")) {			
            $('input#cmd').val('EDIT');
			document.fboardlist.submit();
		}
        
	} else {
		alert("수정할 항목을 하나 이상 선택해 주세요.");
	}
}

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


    <!-- 등록정보 -->
    <div class="container_wr">
        <form name="fboardlist" id="fboardlist" action="process.php" method="post">
            <div class="tbl_head01 tbl_wrap">
                <h2 class="h2_frm" style="margin-top: 0;">등록정보</h2>
                <table>
                    <caption>등록정보</caption>
                    <colgroup>
                        <col width="50px" />
                        <col width="15%" />
                        <col width="*" />
                        <col width="3%" />
                        <col width="15%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="chkall" class="sound_only">공식계정 전체</label>
                                <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                            </th>
                            <th scope="col">종류</th>
                            <th scope="col">링크주소</th>
                            <th scope="col">순서</th>
                            <th scope="col">비고</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            if($result){
                                foreach($result as $key => $row){
                        ?>
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $row[$primary_key]; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row[$primary_key]; ?>" id="chk_<?php echo $row[$primary_key]; ?>">
                            </td>
                            <td>
                                <label for="ofi_type_<?php echo $row[$primary_key]; ?>" class="sound_only">노출여부</label>
                                <select name="ofi_type[<?php echo $row[$primary_key]; ?>]" id="ofi_type_<?php echo $row[$primary_key]; ?>">
                                    <?php
                                        for($k = 1; $k <= 7; $k++){
                                    ?>                                
                                    <option value="<?php echo $k; ?>" <?php echo $row['ofi_type'] == $k ? 'selected' : '';?>><?php echo getSNSType($k); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <label for="ofi_url_<?php echo $row[$primary_key]; ?>" class="sound_only">링크주소<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="ofi_url[<?php echo $row[$primary_key]; ?>]" value="<?php echo $row['ofi_url']; ?>" id="ofi_url_<?php echo $row[$primary_key]; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="ofi_order_<?php echo $row[$primary_key]; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="ofi_order[<?php echo $row[$primary_key]; ?>]" value="<?php echo $row['ofi_order']; ?>" id="ofi_order_<?php echo $row[$primary_key]; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="ofi_etc_<?php echo $row[$primary_key]; ?>" class="sound_only">비고</label>
                                <input type="text" name="ofi_etc[<?php echo $row[$primary_key]; ?>]" value="<?php echo $row['ofi_etc']; ?>" id="ofi_etc_<?php echo $row[$primary_key]; ?>" class="frm_input full_input">
                            </td>
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
            <input type="button" name="act_button" value="선택수정" onclick="groupEdit();" style="cursor: pointer;" class="btn_02 btn">
            <input type="submit" name="act_button" value="선택삭제" onclick="groupDelete();" class="btn_02 btn">
        </div>
    </div>
    <!-- //등록정보 -->

    <!-- 계정추가 -->
    <div class="container_wr">
        <form name="faddlist" id="faddlist" action="process.php" method="post">
            <div class="tbl_head01 tbl_wrap">
                <h2 class="h2_frm" style="margin-top: 0;">계정추가</h2>
                <table>
                    <caption>계정추가</caption>
                    <colgroup>
                        <col width="15%" />
                        <col width="*" />
                        <col width="3%" />
                        <col width="15%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">종류</th>
                            <th scope="col">링크주소</th>
                            <th scope="col">순서</th>
                            <th scope="col">비고</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td>
                                <label for="ofi_type" class="sound_only">노출여부</label>
                                <select name="ofi_type" id="ofi_type">
                                    <?php
                                        for($k = 1; $k <= 7; $k++){
                                    ?>                                
                                    <option value="<?php echo $k; ?>"><?php echo getSNSType($k); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <label for="ofi_url" class="sound_only">링크주소<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="ofi_url" value="" id="ofi_url" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="ofi_order" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="ofi_order" value="" id="ofi_order" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="ofi_etc" class="sound_only">비고</label>
                                <input type="text" name="ofi_etc" value="" id="ofi_etc" class="frm_input full_input">
                            </td>
                    </tbody>
                </table>
            </div>
            <div class="btn_set txt_r">
                <input type="submit" name="act_button" value="추가" class="btn_01 btn">
            </div>
			<input type="hidden" name="cmd" id="cmd2" value="WRITE"/> 
        </form>
    </div>
    <!-- //계정추가 -->
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>