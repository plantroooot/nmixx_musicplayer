<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/seo/Seo.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "../config.php";

/*
| ----------------------------------------------------------------------------------------
| SEO 리스트
| ----------------------------------------------------------------------------------------
*/
$pageTitle = 'SEO설정 관리';
$seo = new Seo($pageRows, $tablename, $_REQUEST, $primary_key);
$rowPageCount = $seo->getCount($_REQUEST);
$result = $seo->getList($_REQUEST);
$result_all = $seo->getListAll($_REQUEST);
$colspan = 7;

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

$(document).on('change', '#seo_parent', function(){
    let parent2 = $('#seo_parent option:selected').attr('data-parent2');
    let depth = $('#seo_parent option:selected').attr('data-depth');

    $('#seo_parent2').val(parent2);
    $('#seo_depth').val(parseInt(depth)+1);
});

</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageTitle?></h1>


    <!-- 등록정보 -->
    <div class="container_wr">
        <form name="fboardlist" id="fboardlist" action="/admin/seo/process.php" method="post">
            <div class="tbl_head01 tbl_wrap">
                <h2 class="h2_frm" style="margin-top: 0;">등록정보</h2>
                <table>
                    <caption>등록정보</caption>
                    <colgroup>
                        <col width="50px" />
                        <col width="15%" />
                        <col width="15%" />
                        <col width="*" />
                        <col width="3%" />
                        <col width="8%" />
                        <col width="8%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="chkall" class="sound_only">SEO 전체</label>
                                <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                            </th>
                            <th scope="col">메뉴명</th>
                            <th scope="col">메뉴명(영문)</th>
                            <th scope="col">링크주소</th>
                            <th scope="col">순서</th>
                            <th scope="col">새창여부</th>
                            <th scope="col">노출여부</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            /*
                            | ----------------------------------------------------------------------------------------
                            | depth1
                            | ----------------------------------------------------------------------------------------
                            */
                            if($result){
                                foreach($result as $key => $row){
                        ?>
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $row['seo_id']; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row['seo_id']; ?>" id="chk_<?php echo $row['seo_id']; ?>">
                            </td>
                            <td>
                                <label for="seo_name_<?php echo $row['seo_id']; ?>" class="sound_only">메뉴명<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_name[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_name']; ?>" id="seo_name_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_name_en_<?php echo $row['seo_id']; ?>" class="sound_only">메뉴명<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_name_en[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_name_en']; ?>" id="seo_name_en_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_url_<?php echo $row['seo_id']; ?>" class="sound_only">링크주소<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_url[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_url']; ?>" id="seo_url_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_order_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_order[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_order']; ?>" id="seo_order_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_is_blank_<?php echo $row['seo_id']; ?>" class="sound_only">새창여부</label>
                                <select name="seo_is_blank[<?php echo $row['seo_id']; ?>]" id="seo_is_blank_<?php echo $row['seo_id']; ?>">
                                    <option value="Y" <?php echo $row['seo_is_blank'] == 'Y' ? 'selected' : '';?>>사용함</option>
                                    <option value="N" <?php echo $row['seo_is_blank'] == 'N' ? 'selected' : '';?>>사용안함</option>
                                </select>
                            </td>
                            <td>
                                <label for="seo_activated_<?php echo $row['seo_id']; ?>" class="sound_only">노출여부</label>
                                <select name="seo_activated[<?php echo $row['seo_id']; ?>]" id="seo_activated_<?php echo $row['seo_id']; ?>">
                                    <option value="Y" <?php echo $row['seo_activated'] == 'Y' ? 'selected' : '';?>>사용함</option>
                                    <option value="N" <?php echo $row['seo_activated'] == 'N' ? 'selected' : '';?>>사용안함</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                            if($row['depth2']) {
                                foreach($row['depth2'] as $key2 => $row2){
                        ?>
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $row2['seo_id']; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row2['seo_id']; ?>" id="chk_<?php echo $row2['seo_id']; ?>">
                            </td>
                            <td>
                                <div class="menu_children">
                                    <span>
                                        <span>
                                            <img src="/admin/img/menulist_sub.png" alt="depth2">
                                        </span>
                                    </span>
                                    <label for="seo_name_<?php echo $row2['seo_id']; ?>" class="sound_only">메뉴명<strong class="sound_only"> 필수</strong></label>
                                    <input type="text" name="seo_name[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_name']; ?>" id="seo_name_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                                </div>
                            </td>
                            <td>
                                <label for="seo_name_en_<?php echo $row2['seo_id']; ?>" class="sound_only">메뉴명<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_name_en[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_name_en']; ?>" id="seo_name_en_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_url_<?php echo $row2['seo_id']; ?>" class="sound_only">링크주소<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_url[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_url']; ?>" id="seo_url_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_order_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_order[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_order']; ?>" id="seo_order_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_is_blank_<?php echo $row2['seo_id']; ?>" class="sound_only">새창여부</label>
                                <select name="seo_is_blank[<?php echo $row2['seo_id']; ?>]" id="seo_is_blank_<?php echo $row2['seo_id']; ?>">
                                    <option value="Y" <?php echo $row2['seo_is_blank'] == 'Y' ? 'selected' : '';?>>사용함</option>
                                    <option value="N" <?php echo $row2['seo_is_blank'] == 'N' ? 'selected' : '';?>>사용안함</option>
                                </select>
                            </td>
                            <td>
                                <label for="seo_activated_<?php echo $row2['seo_id']; ?>" class="sound_only">노출여부</label>
                                <select name="seo_activated[<?php echo $row2['seo_id']; ?>]" id="seo_activated_<?php echo $row2['seo_id']; ?>">
                                    <option value="Y" <?php echo $row2['seo_activated'] == 'Y' ? 'selected' : '';?>>사용함</option>
                                    <option value="N" <?php echo $row2['seo_activated'] == 'N' ? 'selected' : '';?>>사용안함</option>
                                </select>
                            </td>
                        </tr>                        
                        <?php
                            if($row2['depth3']) {
                                foreach($row2['depth3'] as $key3 => $row3){
                        ?>
                        
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $row3['seo_id']; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row3['seo_id']; ?>" id="chk_<?php echo $row3['seo_id']; ?>">
                            </td>
                            <td>
                                <div class="menu_children">
                                    <span>
                                        <span>
                                            <img src="/admin/img/menulist_sub.png" alt="depth2">
                                        </span>
                                        <span>
                                            <img src="/admin/img/menulist_sub.png" alt="depth2">
                                        </span>
                                    </span>
                                    <label for="seo_name_<?php echo $row3['seo_id']; ?>" class="sound_only">메뉴명<strong class="sound_only"> 필수</strong></label>
                                    <input type="text" name="seo_name[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_name']; ?>" id="seo_name_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                                </div>
                            </td>
                            <td>
                                <label for="seo_name_en_<?php echo $row3['seo_id']; ?>" class="sound_only">메뉴명<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_name_en[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_name_en']; ?>" id="seo_name_en_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_url_<?php echo $row3['seo_id']; ?>" class="sound_only">링크주소<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_url[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_url']; ?>" id="seo_url_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_order_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_order[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_order']; ?>" id="seo_order_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_is_blank_<?php echo $row3['seo_id']; ?>" class="sound_only">새창여부</label>
                                <select name="seo_is_blank[<?php echo $row3['seo_id']; ?>]" id="seo_is_blank_<?php echo $row3['seo_id']; ?>">
                                    <option value="Y" <?php echo $row3['seo_is_blank'] == 'Y' ? 'selected' : '';?>>사용함</option>
                                    <option value="N" <?php echo $row3['seo_is_blank'] == 'N' ? 'selected' : '';?>>사용안함</option>
                                </select>
                            </td>
                            <td>
                                <label for="seo_activated_<?php echo $row3['seo_id']; ?>" class="sound_only">노출여부</label>
                                <select name="seo_activated[<?php echo $row3['seo_id']; ?>]" id="seo_activated_<?php echo $row3['seo_id']; ?>">
                                    <option value="Y" <?php echo $row3['seo_activated'] == 'Y' ? 'selected' : '';?>>사용함</option>
                                    <option value="N" <?php echo $row3['seo_activated'] == 'N' ? 'selected' : '';?>>사용안함</option>
                                </select>
                            </td>
                        </tr>

                        <?php                   }
                                            }
                                        }
                                    }
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
        </div>
    </div>
    <!-- //등록정보 -->
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>