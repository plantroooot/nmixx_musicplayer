<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Board.class.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";
    
    include "../post/config.php";

    $post = new Post($pageRows, $tablename, $_REQUEST, $primary_key);

    if($_REQUEST['no']){
        $data = $post->getData($_REQUEST['no'], true);
    }

    include_once $_SERVER['DOCUMENT_ROOT']."/header.php";
?>
<div id="sub" class="guide">
    <div class="sub-wrap">
        <?php
            include_once $_SERVER['DOCUMENT_ROOT']."/include/subvisual.php";
        ?>
        <section class="section section1">
            <div class="sec-wrap">
                <div class="size">                    
                    <div class="board_view_wrap">
                        <div class="board_view">
                            <div class="title">
                                <?php echo $data['post_top'] == 'Y' ? '[📢]' : ''?><?php echo $data['post_title'] ?>
                            </div>
                            <div class="info">
                                <dl>
                                    <dt>글쓴이</dt>
                                    <dd><?php echo $data['post_username'] ?></dd>
                                </dl>
                                <dl>
                                    <dt>작성일</dt>
                                    <dd><?php echo getYMD($data['post_datetime']) ?></dd>
                                </dl>
                                <dl>
                                    <dt>조회</dt>
                                    <dd><?php echo $data['post_readno'] ?></dd>
                                </dl>
                            </div>
                            <div class="cont">
                                <?php echo $data['post_contents'] ?>
                            </div>
                        </div>
                        <div class="bt_wrap">
                            <a href="<?=$post->getQueryString('/post/', 0, $_REQUEST)?>" class="on">목록</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
?>