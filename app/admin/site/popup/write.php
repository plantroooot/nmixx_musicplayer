<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Popup.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

$pageTitle = '팝업관리';
$popup = new Popup($pageRows, $tablename, $_REQUEST, $primary_key);

if($_REQUEST['no']){
    $data = $popup->getData($_REQUEST['no'], false);
}

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<script>

	function fboardform_submit(frm) {
        
		$('#fboardform').submit();

	}
	
</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageWriteTitle?></h1>
    <div class="container_wr">
        <form name="fboardform" id="fboardform" action="/admin/site/popup/process.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
            <section id="anc_bo_basic">
                <h2 class="h2_frm">등록정보</h2>
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                        <caption>등록정보</caption>
                        <colgroup>
							<col width="12.5%">
							<col width="37.5%">
							<col width="12.5%">
							<col width="37.5%">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th scope="row">활성화 여부</th>
                                <td colspan="3">                                    
                                    <div class="chk_list">                                        
                                        <span class="radio_box">
                                            <input type="radio" name="pop_activated" value="Y" id="pop_activated_y" <?php echo $data['pop_activated'] == 'Y' ? 'checked' : '';?>>
                                            <label for="pop_activated_y">활성화</label>                                        
                                        </span>                                   
                                        <span class="radio_box">
                                            <input type="radio" name="pop_activated" value="Y" id="pop_activated_n" <?php echo $data['pop_activated'] == 'N' ? 'checked' : '';?>>
                                            <label for="pop_activated_n">비활성화</label>                                        
                                        </span>
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="pop_title">제목<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <input type="text" name="pop_title" value="<?php echo $data['pop_title']; ?>" id="pop_title" required class="required frm_input" size="40" maxlength="120">
                                </td>
                            </tr>  
                            <tr>                                
                                <th scope="row"><label for="pop_start_day">시작일<strong class="sound_only">필수</strong></label></th>
                                <td>
                                    <input type="text" name="pop_start_day" value="<?php echo getYMD($data['pop_start_day']); ?>" id="pop_start_day" required class="required frm_input datepicker2" size="40" maxlength="120" autocomplete="off">
                                </td>                           
                                <th scope="row"><label for="pop_end_day">종료일<strong class="sound_only">필수</strong></label></th>
                                <td>
                                    <input type="text" name="pop_end_day" value="<?php echo getYMD($data['pop_end_day']); ?>" id="pop_end_day" required class="required frm_input datepicker3" size="40" maxlength="120" autocomplete="off">
                                </td>
                            </tr>  
                            <tr>
                                <th scope="row">가운데여부</th>
                                <td colspan="3">  
                                    <span class="check_box">                                                
                                        <input type="checkbox" name="pop_center_yn" value="Y" id="pop_center_yn" <?php echo $data['pop_center_yn'] == 'Y' ? 'checked' : ''; ?>>
                                        <label for="pop_center_yn">가운데정렬</label>                                        
                                    </span>
                                </td>
                            </tr>   
                            <tr>                                
                                <th scope="row"><label for="pop_area_left">좌측위치<strong class="sound_only">필수</strong></label></th>
                                <td>
                                    <input type="text" name="pop_area_left" value="<?php echo $data['pop_area_left']; ?>" id="pop_area_left" class="frm_input" size="40" maxlength="120" autocomplete="off">px
                                </td>                           
                                <th scope="row"><label for="pop_area_top">상단위치<strong class="sound_only">필수</strong></label></th>
                                <td>
                                    <input type="text" name="pop_area_top" value="<?php echo $data['pop_area_top']; ?>" id="pop_area_top" class="frm_input" size="40" maxlength="120" autocomplete="off">px
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">이미지</th>
                                <td colspan="3">
                                    <? if ($data['pop_imagename']) { ?>
                                    기존파일 : <?=$data['pop_imagename_org']?>&nbsp;&nbsp;<input type="checkbox" name="pop_imagename_chk" id="pop_imagename_chk" value="1"/>기존파일삭제<br/>
                                    <? } ?>
                                    <input type="file" id="pop_imagename" name="pop_imagename" class="input92p" title="이미지파일을 업로드 해주세요." /><br/>
                                    <font color="red">※ 이미지 사이즈는 적당한 사이즈로 미리 변경하신 후에 저장하세요!</font>
                                </td>
                            </tr> 
                            <tr>
                                <th scope="row"><label for="pop_relation_url">상세보기 URL<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <input type="text" name="pop_relation_url" value="<?php echo $data['pop_relation_url']; ?>" id="pop_relation_url" class="frm_input" size="140" maxlength="40">
                                    <p>※ 유튜브 링크는 반드시 유튜브영상 오른쪽 클릭 -> 동영상 URL복사로 복사된 URL을 넣어주세요.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
			<input type="hidden" name="cmd" id="cmd" value="<?php echo isset($_REQUEST['no']) && $_REQUEST['no'] ? 'EDIT' : 'WRITE'?>"/> 
			<input type="hidden" name="pop_id" id="pop_id" value="<?php echo $data['pop_id']; ?>"/> 
            <div class="btn_fixed_top">
                <a href="<?=$popup->getQueryString('index.php', 0, $_REQUEST)?>" class="btn_02 btn">목록</a>
                <input type="submit" value="저장" class="btn_submi btn btn_01" accesskey="s">
            </div>
        </form>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>