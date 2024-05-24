<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/head.php";

?>
<script>
$(window).load(function(){
	var title = '<?php echo $pageTitle?>';

    // console.log(title);

    $('#hd .gnb_ul').find('li').each(function(){
		// var txt=$(this).children('a').text().replace(/[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\''\\]/g,"");
		// if( txt.replaceAll(" ","") == title.replaceAll(" ", "") ){
		// 	$(this).children('a').addClass('on');
		// }

        if( $(this).find('ul').length > 0 ){
			$(this).find('li').each(function(){
				if( $(this).children('.gnb_2da').text().replaceAll(" ","") == title.replaceAll(" ","") ){
					$(this).children('.gnb_2da').addClass('on');
					$(this).parents('li').addClass('on');
				}
			});
		}
    });
});

</script>
<div id="bodyWrap">
<header id="hd">
    <h1><?php echo COMPANY_NAME ?> 관리자</h1>
    <div id="hd_top">
        <button type="button" id="btn_gnb" class="btn_gnb_close">메뉴</button>
        <div id="logo"><a href="/admin/dashboard/"><img src="/admin/img/logo.png" alt="<?php echo COMPANY_NAME ?> 관리자"></a></div>

        <div id="tnb">
            <ul>
                <li class="tnb_li"><a href="/" class="tnb_community" target="_blank" title="커뮤니티 바로가기">커뮤니티 바로가기</a></li>
                <li class="tnb_li"><button type="button" class="tnb_mb_btn">관리자<span class="./img/btn_gnb.png">메뉴열기</span></button>
                    <ul class="tnb_mb_area">
                        <li id="tnb_logout"><a href="/admin/include/logout.php">로그아웃</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <nav id="gnb" class="gnb_large">
        <h2>관리자 주메뉴</h2>
        <ul class="gnb_ul">            
            <li class="gnb_li">
                <button type="button" class="btn_op menu-300 menu-order-1" title="게시판관리">게시판관리</button>
                <div class="gnb_oparea_wr">
                    <div class="gnb_oparea">
                        <h3>게시판관리</h3>
                        <ul>
                            <li>
                                <a href="/admin/board/" class="gnb_2da">게시판관리</a>
                            </li>
                        </ul>                        
                    </div>
                </div>
            </li>  
            <li class="gnb_li">
                <button type="button" class="btn_op menu-100 menu-order-1" title="SEO관리">SEO관리</button>
                <div class="gnb_oparea_wr">
                    <div class="gnb_oparea">
                        <h3>SEO관리</h3>
                        <ul>
                            <li>
                                <a href="/admin/seo/" class="gnb_2da">메뉴 관리</a>
                            </li>
                            <li>
                                <a href="/admin/seo/settings/" class="gnb_2da">SEO설정 관리</a>
                            </li>
                        </ul>                        
                    </div>
                </div>
            </li>  
            <li class="gnb_li">
                <button type="button" class="btn_op menu-order-1" title="컨텐츠관리">컨텐츠관리</button>
                <div class="gnb_oparea_wr">
                    <div class="gnb_oparea">
                        <h3>컨텐츠관리</h3>
                        <ul>
                            <?php echo get_board_list(); ?>
                            <li>
                                <a href="/admin/official_info/" class="gnb_2da">공식계정 관리</a>
                            </li>
                            <li>
                                <a href="/admin/schedule/" class="gnb_2da">스케줄 관리</a>
                            </li>
                        </ul>                        
                    </div>
                </div>
            </li>  
            <?/*
            <li class="gnb_li">
                <button type="button" class="btn_op menu-200 menu-order-1" title="관리자관리">관리자관리</button>
                <div class="gnb_oparea_wr">
                    <div class="gnb_oparea">
                        <h3>관리자관리</h3>
                        <ul>
                            <li>
                                <a href="" class="gnb_2da">기본환경설정</a>
                            </li>
                        </ul>                        
                    </div>
                </div>
            </li>
            */?>
        </ul>
    </nav>
</header>
<script>
    jQuery(function($) {

        var menu_cookie_key = 'g5_admin_btn_gnb';

        $(".tnb_mb_btn").click(function() {
            $(".tnb_mb_area").toggle();
        });

        $("#btn_gnb").click(function() {

            var $this = $(this);

            try {
                if (!$this.hasClass("btn_gnb_open")) {
                    set_cookie(menu_cookie_key, 1, 60 * 60 * 24 * 365);
                } else {
                    delete_cookie(menu_cookie_key);
                }
            } catch (err) {}

            $("#container").toggleClass("container-small");
            $("#gnb").toggleClass("gnb_small");
            $this.toggleClass("btn_gnb_open");

        });

        $(".gnb_ul li .btn_op").click(function() {
            $(this).parent().addClass("on").siblings().removeClass("on");
        });

        

    });
</script>

<div id="wrapper">