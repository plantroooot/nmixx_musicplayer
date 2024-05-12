<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";
$board = new Board($pageRows, $tablename, $_REQUEST);

if($_REQUEST['no']){
    $data = $board->getData($_REQUEST['no'], false);
}

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<script>
    $(document).on('change', '.sel_td input[type="checkbox"]', function(){
        let is_checked = $(this).is(':checked');
        console.log(is_checked);

        if(is_checked){
            $(this).siblings('p').css('display', 'block');
        }else{
            $(this).siblings('p').css('display', 'none');
            $(this).siblings('p').find('input[type="text"]').val(0);
        }

    });
</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageWriteTitle?></h1>
    <div class="container_wr">
        <form name="fboardform" id="fboardform" action="process.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
            <section id="anc_bo_basic">
                <h2 class="h2_frm">게시판 기본 설정</h2>
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                        <caption>게시판 기본 설정</caption>
                        <colgroup>
                            <col class="grid_4">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <th scope="row"><label for="brd_title">게시판 제목<strong class="sound_only">필수</strong></label></th>
                                <td colspan="2">
                                    <input type="text" name="brd_title" value="<?php echo $data['brd_title']; ?>" id="brd_title" required class="required frm_input" size="40" maxlength="120">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="brd_code">게시판 코드<strong class="sound_only">필수</strong></label></th>
                                <td colspan="2">
									<span class="text-sm">/board/?bname=</span>
                                    <input type="text" name="brd_code" value="<?php echo $data['brd_code']; ?>" id="brd_code" required class="required frm_input" size="10" maxlength="120" <?php echo $data['brd_code'] ? 'readonly' : ''; ?>>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="brd_file">첨부파일 사용</label></th>
                                <td class="sel_td">
                                    <input type="checkbox" name="brd_file" value="1" id="brd_file" <?php echo $data['brd_file'] == 1 ? 'checked' : ''; ?>>
                                    사용
                                    <p style="display: <?php echo $data['brd_file'] == 1 ? 'block' : 'none'; ?>;">
                                        <input type="text" name="brd_filecnt" value="<?php echo $data['brd_filecnt'] ? $data['brd_filecnt'] : 0; ?>" id="brd_filecnt" class="frm_input" size="2" maxlength="3" oninput="isOnlyNumber(this);">
                                        <span>개</span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="brd_link">관련링크 사용</label></th>
                                <td class="sel_td">
                                    <input type="checkbox" name="brd_link" value="1" id="brd_link" <?php echo $data['brd_link'] == 1 ? 'checked' : ''; ?>>
                                    사용
                                    <p style="display: <?php echo $data['brd_link'] == 1 ? 'block' : 'none'; ?>;">
                                        <input type="text" name="brd_linkcnt" value="<?php echo $data['brd_linkcnt'] ? $data['brd_linkcnt'] : 0; ?>" id="brd_linkcnt" class="frm_input" size="2" maxlength="3" oninput="isOnlyNumber(this);">
                                        <span>개</span>
                                    </p>
                                </td>
                            </tr>                         
                            <tr>
                                <th scope="row"><label for="brd_newdate">New 아이콘보이기<strong class="sound_only">필수</strong></label></th>
                                <td colspan="2">
                                    <input type="text" name="brd_newdate" value="<?php echo $data['brd_newdate'] ? $data['brd_newdate'] : 0; ?>" id="brd_newdate" required class="required frm_input" size="3" maxlength="3">
									<p>※ 해당 일수 동안 New 아이콘이 보입니다.</p>
									<p>※ New아이콘 기능을 사용하지 않으시려면 0으로 설정해주세요.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </section>
			<input type="hidden" name="cmd" id="cmd" value="<?php echo isset($_REQUEST['no']) && $_REQUEST['no'] ? 'EDIT' : 'WRITE'?>"/> 
            <div class="btn_fixed_top">
                <a href="<?=$board->getQueryString('index.php', 0, $_REQUEST)?>" class="btn_02 btn">목록</a>
                <input type="submit" value="등록" class="btn_submi btn btn_01" accesskey="s">
            </div>
        </form>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>