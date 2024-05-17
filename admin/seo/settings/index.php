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
            $('input#cmd').val('METAEDIT');
			document.fboardlist.submit();
		}
        
	} else {
		alert("수정할 항목을 하나 이상 선택해 주세요.");
	}
}

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
                        <col width="75px" />
                        <col width="7%" />
                        <col width="7%" />
                        <col width="8%" />
                        <col width="9%" />
                        <col width="9%" />
                        <col width="13%" />
                        <col width="13%" />
                        <col width="16%" />
                        <col width="16%" />
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
                            <th scope="col">title</th>
                            <th scope="col">title(영문)</th>
                            <th scope="col">description</th>
                            <th scope="col">description(영문)</th>
                            <th scope="col">keywords</th>
                            <th scope="col">keywords(영문)</th>
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
                            <td class="txt_l"><?php echo $row['seo_name']; ?></td>
                            <td class="txt_l"><?php echo $row['seo_name_en']; ?></td>
                            <td class="txt_l">
                                <a href="<?php echo $row['seo_url']; ?>" target="_blank"><?php echo $row['seo_url']; ?></a>
                            </td>
                            <td>
                                <label for="seo_title_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_title[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_title']; ?>" id="seo_title_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_title_en_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_title_en[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_title_en']; ?>" id="seo_title_en_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            
                            <td>
                                <label for="seo_description_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_description[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_description']; ?>" id="seo_description_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_description_en_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_description_en[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_description_en']; ?>" id="seo_description_en_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>                            
                            <td>
                                <label for="seo_keywords_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_keywords[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_keywords']; ?>" id="seo_keywords_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_keywords_en_<?php echo $row['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_keywords_en[<?php echo $row['seo_id']; ?>]" value="<?php echo $row['seo_keywords_en']; ?>" id="seo_keywords_en_<?php echo $row['seo_id']; ?>" required class="required frm_input full_input">
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
                            <td class="txt_l">
                                <div class="menu_children">
                                    <span>
                                        <span>
                                            <img src="/admin/img/menulist_sub.png" alt="depth3">
                                        </span>
                                    </span>
                                    <span>
                                        <?php echo $row2['seo_name']; ?>
                                    </span>
                                </div>
                            </td>
                            <td class="txt_l"><?php echo $row2['seo_name_en']; ?></td>
                            <td class="txt_l">
                                <a href="<?php echo $row2['seo_url']; ?>" target="_blank"><?php echo $row2['seo_url']; ?></a>
                            </td>
                            <td>
                                <label for="seo_title_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_title[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_title']; ?>" id="seo_title_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_title_en_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_title_en[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_title_en']; ?>" id="seo_title_en_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            
                            <td>
                                <label for="seo_description_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_description[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_description']; ?>" id="seo_description_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_description_en_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_description_en[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_description_en']; ?>" id="seo_description_en_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>                            
                            <td>
                                <label for="seo_keywords_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_keywords[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_keywords']; ?>" id="seo_keywords_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_keywords_en_<?php echo $row2['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_keywords_en[<?php echo $row2['seo_id']; ?>]" value="<?php echo $row2['seo_keywords_en']; ?>" id="seo_keywords_en_<?php echo $row2['seo_id']; ?>" required class="required frm_input full_input">
                            </td>                  
                        <?php
                            if($row2['depth3']) {
                                foreach($row2['depth3'] as $key3 => $row3){
                        ?>
                        
                        <tr>
                            <td class="td_chk">
                                <label for="chk_<?php echo $row3['seo_id']; ?>" class="sound_only"></label>
                                <input type="checkbox" name="chk[]" value="<?php echo $row3['seo_id']; ?>" id="chk_<?php echo $row3['seo_id']; ?>">
                            </td>
                            <td class="txt_l">
                                <div class="menu_children">
                                    <span>
                                        <span>
                                            <img src="/admin/img/menulist_sub.png" alt="depth3">
                                        </span>
                                        <span>
                                            <img src="/admin/img/menulist_sub.png" alt="depth3">
                                        </span>
                                    </span>
                                    <span>
                                        <?php echo $row3['seo_name']; ?>
                                    </span>
                                </div>
                            </td>
                            <td class="txt_l"><?php echo $row3['seo_name_en']; ?></td>
                            <td class="txt_l">
                                <a href="<?php echo $row3['seo_url']; ?>" target="_blank"><?php echo $row3['seo_url']; ?></a>
                            </td>
                            <td>
                                <label for="seo_title_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_title[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_title']; ?>" id="seo_title_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_title_en_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_title_en[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_title_en']; ?>" id="seo_title_en_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            
                            <td>
                                <label for="seo_description_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_description[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_description']; ?>" id="seo_description_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_description_en_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_description_en[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_description_en']; ?>" id="seo_description_en_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>                            
                            <td>
                                <label for="seo_keywords_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_keywords[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_keywords']; ?>" id="seo_keywords_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
                            <td>
                                <label for="seo_keywords_en_<?php echo $row3['seo_id']; ?>" class="sound_only">순서<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="seo_keywords_en[<?php echo $row3['seo_id']; ?>]" value="<?php echo $row3['seo_keywords_en']; ?>" id="seo_keywords_en_<?php echo $row3['seo_id']; ?>" required class="required frm_input full_input">
                            </td>
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
			<input type="hidden" name="cmd" id="cmd" value="METAEDIT"/> 
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