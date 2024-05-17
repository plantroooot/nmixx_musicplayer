<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/seo/Seo.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "../post/config.php";

$pageTitle = '업데이트 내역';
$post = new Post($pageRows, $tablename, $_REQUEST, $primary_key);

if($_REQUEST['no']){
    $data = $post->getData($_REQUEST['no'], false);
}

$board = new Board($pageRows, 'board', $_REQUEST);
$brd_data = $board->getBoardData($_REQUEST['bcode'], false);

$seo = new Seo(9999, 'seo', $_REQUEST, 'seo_id');
$rowPageCount = $seo->getCount($_REQUEST);
$result_all = $seo->getListAll($_REQUEST);

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<script>
	var oEditors; // 에디터 객체 담을 곳 - 국문
	var oEditors2; // 에디터 객체 담을 곳 - 영문
	// jQuery(window).load(function(){
	// 	oEditors = setEditor("post_contents"); // 에디터 셋팅 - 국문
	// 	oEditors2 = setEditor("post_contents_en"); // 에디터 셋팅 - 영문
	// });

	function fboardform_submit(frm) {
		/*var regex=/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
		if ($("#name").val() == "") {
			alert('작성자를 입력해 주세요.');
			$("#name").focus();
			return false;
		}
		if ($("#registdate").val() != "") {
			var regex2=/[0-9]{4}[\-][0-1][0-9][\-][0-3][0-9]\s[0-2][0-9]:[0-6][0-9]:[0-6][0-9]$/i; 
			if(!regex2.test($("#registdate").val())){
				alert('잘못된 날짜 형식입니다.\\n올바로 입력해 주세요.\\n ex)2013-02-14 03:28:85');
				$("#registdate").focus();
				return false;
			} 
		}*/

        // if($('input[name="lang_kr"]:checked').length == 0 && $('input[name="lang_en"]:checked').length == 0){
		// 	alert('사이트 노출을 선택해 주세요.');
		// 	return false;
        // }

        // if($('input[name="lang_kr"]:checked').length > 0 || ($('input[name="lang_kr"]:checked').length > 0 && $('input[name="lang_en"]:checked').length > 0)){
        //     if ($("#title").val() == "") {
        //         alert('국문 제목을 입력해 주세요.');
        //         $("#title").focus();
        //         return false;
        //     }

        //     var sHTML = oEditors.getById["contents"].getIR();
        //     if (sHTML == "" || sHTML == "<p>&nbsp;</p>"  || sHTML == "<p><br></p>") {
        //         alert('국문 내용을 입력해 주세요.');
        //         oEditors.getById["contents"].exec("FOCUS");
        //         return false;
        //     }
        // }

        // if($('input[name="lang_en"]:checked').length > 0 || ($('input[name="lang_kr"]:checked').length > 0 && $('input[name="lang_en"]:checked').length > 0)){
        //     if ($("#title_en").val() == "") {
        //         alert('영문 제목을 입력해 주세요.');
        //         $("#title_en").focus();
        //         return false;
        //     }

        //     var sHTML2 = oEditors2.getById["contents_en"].getIR();
        //     if (sHTML2 == "" || sHTML2 == "<p>&nbsp;</p>"  || sHTML2 == "<p><br></p>") {
        //         alert('영문 내용을 입력해 주세요.');
        //         oEditors2.getById["contents_en"].exec("FOCUS");
        //         return false;
        //     }
        // }

        // oEditors.getById["post_contents"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // oEditors2.getById["post_contents_en"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.

		$('#fboardform').submit();

	}
	
</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageWriteTitle?></h1>
    <div class="container_wr">
        <form name="fboardform" id="fboardform" action="/admin/post/process.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
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
                                <th scope="row"><label for="post_datetime">등록일<strong class="sound_only">필수</strong></label></th>
                                <td>
                                    <input type="text" name="post_datetime" value="<?php echo $data['post_datetime']; ?>" id="post_datetime" required class="required frm_input datepicker" size="40" maxlength="120" autocomplete="off">
                                </td>
                                <th scope="row"><label for="post_username">작성자<strong class="sound_only">필수</strong></label></th>
                                <td>
                                    <input type="text" name="post_username" value="<?php echo $data['post_username'] ? $data['post_username'] : $_SESSION['admin_name']; ?>" id="post_username" required class="required frm_input" size="40" maxlength="120" <?php echo $data['post_username'] ? 'readonly' : ''; ?>>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>                

                <h2 class="h2_frm">업데이트 정보</h2>
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                        <caption>업데이트 정보</caption>
                        <colgroup>
							<col width="12.5%">
							<col width="37.5%">
							<col width="12.5%">
							<col width="37.5%">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th scope="row"><label for="post_title_en">업데이트 구분<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <div class="chk_list">
                                        <?php
                                            for($k = 1; $k <= 3; $k++){
                                        ?>
                                        <span class="radio_box">
                                            <input type="radio" name="post_categoryfk" value="<?php echo $k; ?>" id="post_categoryfk<?php echo $k; ?>" <?php echo $data['post_categoryfk'] == $k ? 'checked' : '';?>>
                                            <label for="post_categoryfk<?php echo $k; ?>"><?php echo getUpdateType($k); ?></label>                                        
                                        </span>
                                        <?php } ?>
                                    </div>                                                         
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="post_title">업데이트 메뉴<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <div class="chk_list">
                                    <?php
                                        if ($result_all) {
                                            foreach ($result_all as $key => $row) {
                                                if ($row['seo_name'] != '메인') {
                                                    $checked = '';

                                                    if (isset($_REQUEST['no'])) {
                                                        $upt_menu = explode(',', $data['post_category_menu']);
                                                        if (in_array($row['seo_id'], $upt_menu)) {
                                                            $checked = 'checked';
                                                        }
                                                    }
                                    ?>
                                                    <span class="check_box">                                                
                                                        <input type="checkbox" name="post_category_menu[]" value="<?php echo $row['seo_id']; ?>" id="post_category_menu<?php echo $row['seo_id']; ?>" <?php echo $checked; ?>>
                                                        <label for="post_category_menu<?php echo $row['seo_id']; ?>"><?php echo $row['seo_name']; ?></label>                                        
                                                    </span>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>

                                    </div>
                                </td>
                            </tr>
                            <tr>                                
                                <th scope="row"><label for="post_updatetime2">업데이트 일자<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <input type="text" name="post_updatetime2" value="<?php echo getYMD($data['post_updatetime2']); ?>" id="post_updatetime2" required class="required frm_input datepicker4" size="40" maxlength="120" autocomplete="off">
                                </td>   
                            </tr>
                            <tr>
                                <th scope="row"><label for="post_contents">업데이트 내용(국문)<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <textarea name="post_contents" id="post_contents" style="resize: none;"><?php echo $data['post_contents']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="post_contents_en">업데이트 내용(영문)<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <textarea name="post_contents_en" id="post_contents_en" style="resize: none;"><?php echo $data['post_contents_en']; ?></textarea>
                                </td>
                            </tr>                        
                            <?php if($brd_data['brd_link'] && $brd_data['brd_linkcnt'] > 0){ 
                                    $post_links = json_decode($data['post_links']);
                                    for($k = 0; $k < $brd_data['brd_linkcnt']; $k++){
                            ?>
                            <tr>
                                <th scope="row"><label for="post_link_<?php echo $k+1; ?>">관련링크<strong class="sound_only">필수</strong></label></th>
                                <td colspan="3">
                                    <input type="text" name="post_link[]" value="<?php echo $post_links[$k]; ?>" id="post_link_<?php echo $k+1; ?>" class="required frm_input" size="130" maxlength="120">
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </section>
			<input type="hidden" name="cmd" id="cmd" value="<?php echo isset($_REQUEST['no']) && $_REQUEST['no'] ? 'EDIT' : 'WRITE'?>"/> 
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $data['post_id']; ?>"/> 
			<input type="hidden" name="brd_id" id="brd_id" value="<?php echo $brd_data['brd_id']; ?>"/> 
			<input type="hidden" name="bcode" id="bcode" value="<?php echo $brd_data['brd_code']; ?>"/> 
            <div class="btn_fixed_top">
                <a href="<?=$post->getQueryString('index.php', 0, $_REQUEST)?>" class="btn_02 btn">목록</a>
                <input type="submit" value="저장" class="btn_submi btn btn_01" accesskey="s">
            </div>
        </form>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>