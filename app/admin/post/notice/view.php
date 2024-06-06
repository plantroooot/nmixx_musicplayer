<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "../post/config.php";


$pageTitle = '공지사항';
$post = new Post($pageRows, $tablename, $_REQUEST, $primary_key);

if($_REQUEST['no']){
    $data = $post->getData($_REQUEST['no'], false);
}

$board = new Board($pageRows, 'board', $_REQUEST);
$brd_data = $board->getBoardData($_REQUEST['bcode'], false);

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageViewTitle?></h1>
    <div class="container_wr">
        <form name="fboardform" id="fboardform" action="process.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
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
                                <th scope="row">등록일</th>
                                <td><?php echo getYMD($data['post_datetime']) ?></td>
                                <th scope="row">작성자</th>
                                <td><?php echo $data['post_username'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">탑공지 여부</th>
                                <td><?php echo $data['post_top'] ? '사용' : '사용안함';?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="h2_frm">공지정보</h2>
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                        <caption>공지정보</caption>
                        <colgroup>
							<col width="12.5%">
							<col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th scope="row">제목(국문)</th>
                                <td><?php echo $data['post_title'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">제목(영문)</th>
                                <td><?php echo $data['post_title_en'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">내용(국문)</th>
                                <td><?php echo $data['post_contents'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">내용(영문)</th>
                                <td><?php echo $data['post_contents_en'] ?></td>
                            </tr>                        
                            <?php if($brd_data['brd_link'] && $brd_data['brd_linkcnt'] > 0){
                                $post_links = json_decode($data['post_links']);
                                for($k = 0; $k < $brd_data['brd_linkcnt']; $k++){
                            ?>
                            <tr>
                                <th scope="row">관련링크</th>
                                <td>
                                    <a href="<?php echo $post_links[$k]; ?>" target="_blank"><?php echo $post_links[$k]; ?></a>                                    
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
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $data['post_id']; ?>"/> 
            <div class="btn_fixed_top">
                <a href="<?=$post->getQueryString('index.php', 0, $_REQUEST)?>" class="btn_02 btn">목록</a>
                <a href="<?=$post->getQueryString('write.php', $data['post_id'], $_REQUEST)?>" class="btn_03 btn">수정</a>
            </div>
        </form>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>