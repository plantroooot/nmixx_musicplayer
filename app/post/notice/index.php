<?php include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/page.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";

include "../post/config.php";

$post = new Post($pageRows, $tablename, $_REQUEST);
$rowPageCount = $post->getCount($_REQUEST);
$result = $post->getList($_REQUEST);

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
                    <div class="board_wrap">
                        <div class="board_list_wrap">
                            <div class="board_list">
                                <div class="top">
                                    <div class="num">번호</div>
                                    <div class="title">제목</div>
                                    <div class="writer">글쓴이</div>
                                    <div class="date">작성일</div>
                                    <div class="count">조회</div>
                                </div>

                                <?
                                    if($result){
                                        foreach($result as $key => $row){
                                            $targetUrl = $post->getQueryString('view.php', $row['post_id'], $_REQUEST);
                                            $topBg = $row['post_top'] == 'Y' ? 'style="background-color: #fffdbb"' : '';
                                ?>                                 
                                <div <?php echo $topBg; ?>>
                                    <?php if($row['post_top'] == 'Y') {?>
                                    <div class="num">[📢]</div>
                                    <?php } else { ?>
                                    <div class="num"><?php echo $rowPageCount[0] - (($post->reqPageNo-1)*$pageRows) - $key?></div>
                                    <? } ?>
                                    <div class="title">
                                        <a href="<?php echo $targetUrl; ?>">                                            
                                            <?php echo $row['post_title']?>
                                        </a>
                                    </div>
                                    <div class="writer"><?php echo $row['post_username']?></div>
                                    <div class="date"><?php echo getYMD($row['post_datetime'])?></div>
                                    <div class="count"><?php echo $row['post_readno']?></div>
                                </div>
                                <?php
                                        }
                                    }
                                    if(!$result){
                                        echo '<div>등록된 공지사항이 없습니다.</div>';
                                    }
                                ?>
                                <!-- <div>
                                    <div class="num">2</div>
                                    <div class="title"><a href="view.html">NMIXX 음원총공팀의 공지사항입니다.</a></div>
                                    <div class="writer">관리자</div>
                                    <div class="date">2024.06.05</div>
                                    <div class="count">222</div>
                                </div>
                                <div>
                                    <div class="num">3</div>
                                    <div class="title"><a href="view.html">공지사항 테스트</a></div>
                                    <div class="writer">관리자</div>
                                    <div class="date">2024.06.05</div>
                                    <div class="count">222</div>
                                </div>
                                <div>
                                    <div class="num">4</div>
                                    <div class="title"><a href="view.html">공지사항 테스트</a></div>
                                    <div class="writer">관리자</div>
                                    <div class="date">2024.06.05</div>
                                    <div class="count">222</div>
                                </div>
                                <div>
                                    <div class="num">5</div>
                                    <div class="title"><a href="view.html">공지사항 테스트</a></div>
                                    <div class="writer">관리자</div>
                                    <div class="date">2024.06.05</div>
                                    <div class="count">222</div>
                                </div> -->
                            </div>
                            <div class="board_page">
                                <!-- <a href="#" class="bt first"><<</a>
                                <a href="#" class="bt prev"><</a>
                                <a href="#" class="num on">1</a>
                                <a href="#" class="num">2</a>
                                <a href="#" class="num">3</a>
                                <a href="#" class="num">4</a>
                                <a href="#" class="num">5</a>
                                <a href="#" class="bt next">></a>
                                <a href="#" class="bt last">>></a> -->
                                <?php echo pageList($post->reqPageNo, $rowPageCount[1], $post->getQueryString('index.php', 0, $_REQUEST))?>
                            </div>
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