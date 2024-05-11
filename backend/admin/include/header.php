<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/page.php";

include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Fb.class.php";
include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";

include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/BoardSetup.class.php";

$freq['sadmin_fk'] = $_SESSION['admin_no'];
$fb = new Fb(99, 'admin_fb', $freq);
$fbPageCount = $fb->getCount($freq);
$fbresult = $fb->getList($freq);

$board2 = new BoardSetup(10, "board_setup", $_REQUEST);
$bdsresult = $board2->getList($_REQUEST);


?>
<script>
$(window).load(function(){

	var title='';

    <?php if(isset($_REQUEST['bname'])){ ?>
		<?if($_REQUEST['bname'] == 'partners'){?>
			title = '파트너사 관리';
		<?} else if($_REQUEST['bname'] == 'partners'){?>
			title = 'Testimonials';
		<?}else{?>
			title = '<?=$boardInfo['P_title']?>';
		<?}?>
    <?php }else{ ?>
		title = '<?=$pageTitle?>';
    <?php } ?>
	
	//주메뉴 on처리
	$('.gnb').children('li').each(function(){
		var txt=$(this).children('a').text().replace(/[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\''\\]/g,"");
		if( txt.replaceAll(" ","") == title.replaceAll(" ", "") ){
			$(this).addClass('bgcolor');
		}

		if( $(this).find('ul').length > 0 ){
			$(this).find('li').each(function(){
				if( $(this).children('.menu').text().replaceAll(" ","") == title.replaceAll(" ","") ){
					$(this).children('.menu').addClass('color beforebg');
					$(this).parents('.parent').addClass('bgcolor');
					$(this).parent('ul').css({'display':'block'});
					$(this).parent('ul').prev('a').find('.arrow').text('keyboard_arrow_up');
				}
			});
			//$(this).text('<span class="material-icons">keyboard_arrow_down</span>');
			$(this).addClass('ico');
		}
	});

	//주메뉴 펼침
	$('.gnb > li.ico > a').on('click',function(){
		$(this).parent('.parent').siblings().children('ul').slideUp(400);
		$(this).next('ul').slideToggle(400);
	});	
	
	//pc 주메뉴 
	$('.navBtn').on('click',function(){
		if($('#main-nav').hasClass('hide')){
			$('#main-nav').removeClass('hide');
			$('.navBtn span').text('keyboard_double_arrow_left');
			$('#wrapper').css({'padding-left':'220px'});
		}else{
			$('#main-nav').addClass('hide');
			$('.navBtn span').text('keyboard_double_arrow_right');
			$('#wrapper').css({'padding-left':'0'});
		}
	});
	
	var slide_wid=0;
	var tab_wid=$('.tabWrap .tab').width();
	
	//탭메뉴 on처리
	$('.tabWrap .tab .swiper-slide').each(function(){
		if( $(this).find('a').eq(0).text().replaceAll(" ","").trim() == title.replaceAll(" ","") ){
			$(this).siblings().removeClass('on');
			$(this).addClass('on');
		}
		slide_wid += $(this).outerWidth(true) + 5;
	});
	
	//탭메뉴 넓이
	var idx=$('.tabWrap .tab .swiper-slide.on').index();
	//var idx_move=$('.tabWrap .tab .swiper-slide.on').offset().left-250+idx*5;
	function tabWrap(){
		if(slide_wid>tab_wid){
			$('.tabWrap .tab .swiper-wrapper').css({width:slide_wid+5,translate3d:(-(slide_wid-tab_wid),0,0)});
		}else{
			$('.tabWrap .tab .swiper-wrapper').css({width:tab_wid,translate3d:(0,0,0)});
		}
	}

	tabWrap();
	
	//주메뉴 별 색깔
	$('.gnb .star').each(function(){
		if($(this).text() == 'star'){
			$(this).css({'color':'#fff'});
		}else{
			$(this).css({'color':'#757575'});
		}
	});
	
	var win_h=$(window).height()-210;
	var cont_h=$('#wrapper .contWrap').height();
	
	//전체 스크롤
	function bodyWrap(){
		if(win_h<cont_h){
			$('#bodyWrap').css({'height':'auto'});
		}else{
			$('#bodyWrap').css({'height':'100%'});
		}
	}
	bodyWrap();

	$(window).resize(function(){
		win_h=$(window).height()-210;
		
		tab_wid=$('.tabWrap .tab').width();

		bodyWrap();
		tabWrap();
		moGnb();
	});
	
	//탭메뉴 스와이퍼
	var tab_swiper = new Swiper(".swiper.tab", {
		slidesPerView: "auto",
		initialSlide:idx,
		spaceBetween: 5,
		allowSlidePrev:true,
		allowSlideNext:true,
		navigation: {
			nextEl: ".tab-button-next",
			prevEl: ".tab-button-prev",
		}
	});
	
	//mo 주메뉴
	function moGnb(){
		if($('.mediaQuery').is(':visible')){
			$('#main-nav').css({'left':'0'});
			$('#main-nav').removeClass('hide');
			$('#wrapper').css({'padding-left':'220px'});
		}else{
			$('#main-nav').css({'left':'-50%'});
			$('.moBtn').removeClass('on');
			$('.moBtn').find('span').text('menu');
			$('.navBg').stop().fadeOut();
		}
	}

	moGnb();
	
	//mo 주메뉴 버튼
	$('.moBtn').on('click',function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$(this).find('span').text('menu');
			$('#main-nav').stop().animate({'left':'-50%'},400);
			$('.navBg').stop().fadeOut(400);
			$("html, body").removeClass("not_scroll");
		}else{
			$(this).addClass('on');
			$(this).find('span').text('close');
			$('#main-nav').stop().animate({'left':'0'},400);
			$('.navBg').stop().fadeIn(400);
			$("html, body").addClass("not_scroll");
		}
	});

	$('.navBg').on('click',function(){
		$('.moBtn').removeClass('on');
		$('.moBtn').find('span').text('menu');
		$('#main-nav').stop().animate({'left':'-50%'},400);
		$('.navBg').stop().fadeOut(400);
		$("html, body").removeClass("not_scroll");
	});
	
});

</script>
<div id="bodyWrap">
<div id="header" class="header clear">
	<div class="moBtn mo">
		<a href="javascript:;">
			<span class="material-icons">menu</span>
		</a>
	</div>
	<h1>
		<?=COMPANY_NAME?> 관리자모드
	</h1>
	<div class="logout">
		<div class="pc">
			<p><b><?=$_SESSION['admin_name']?></b>님</p>
			<input type="button" title="로그아웃" alt="로그아웃" value="로그아웃" onclick="location.href='/admin/include/logout.php';" class="hoverbg"/>
		</div>
		<div class="mo">
			<a href="/admin/include/logout.php">
				<span class="material-icons">logout</span>
			</a>
		</div>
	</div>
</div>
<!-- //header --> 


<script>
	$(function(){
		$('#main-nav .gnb li a.star').on('click',function(){
			var type = "";
			if($(this).data('type')){
				type = $(this).data('type');
			}else{
				type = "menu";
			}
			$.ajax({
				url : '/admin/include/addFb.php',
				data : {
					'name' : $(this).prev().text(),
					'rurl' : $(this).prev().attr('href'),
					'cmd' : 'write',
					'admin_fk' : "<?=$_SESSION['admin_no']?>",
					'types' : type
				},
				type : 'POST',
				success : function(data){
					var r = data.trim();
					console.log(data);
					if(r == "success"){
						alert('즐겨찾기 추가되었습니다.');
						location.reload();
					}else if(r == "already"){
						alert('이미 즐겨찾기된 메뉴입니다.');
					} else if(r == "success2"){
						alert('즐겨찾기 삭제되었습니다.');
						location.reload();
					}else {
						console.log(data.rurl)
						alert('요청처리중 장애가 발생했습니다.');
					}
				}
			});
		});	
	});

	function delFb(name){
		$.ajax({
			url : '/admin/include/addFb.php',
			data : {
				'name' : name,
				'cmd' : 'delete',
				'admin_fk' : "<?=$_SESSION['admin_no']?>"
			},
			type : 'POST',
			success : function(data){
				alert('즐겨찾기 삭제되었습니다.');
				location.reload();
			}
		});
	}
	
	function tabLeft(){
		var idx=$('.tabWrap .tab .swiper-slide.on').index();
		var href=$('.tabWrap .tab .swiper-slide').eq(idx - 1).children('a').eq(0).attr('href');
		location.href=href;
	}

	function tabRight(){
		var idx=$('.tabWrap .tab .swiper-slide.on').index();
		var tab_length=$('.tabWrap .tab .swiper-slide').length;
		if(idx == tab_length - 1){
			var href=$('.tabWrap .tab .swiper-slide').eq(0).children('a').eq(0).attr('href');
		}else{
			var href=$('.tabWrap .tab .swiper-slide').eq(idx + 1).children('a').eq(0).attr('href');
		}
		location.href=href;
	}
</script>
<div id="wrapper">
	<div class="tabWrap clear">

        <?php $arr = array();
			if($fbPageCount[0] == 0){
		?>
		<div class="tb">
			<div class="tbc">
				<p class="txt">메뉴 우측에 있는 ★ 를 클릭하여 즐겨찾기 메뉴를 설정해보세요</p>
			</div>
		</div>
            <?php }else{?>
		<div class="swiper tab">
			<div class="swiper-wrapper">
                <?php
				$i = 0 ;
				
					while($row = mysqli_fetch_assoc($fbresult)){	
						$arr[] = $row['name'];
				?>
				<div class="swiper-slide beforebg">
					<a href="<?=$row['relation_url']?>">
					<?=$row['name']?>
					</a>
					<a href="javascript:;" onclick="delFb('<?=$row['name']?>');" class="btn_close">
						<img src="/admin/img/tab_close.png"/>
					</a>
				</div>
                        <?php $i++;}?>
			</div>
			<div class="swiper-button-next tab-button-next" onClick="tabRight();"></div>
			<div class="swiper-button-prev tab-button-prev" onClick="tabLeft();"></div>
		</div>
            <?php }?>
	</div>


	<div class="navBg"></div>
	<nav id="main-nav">
		<a href="javasciprt:;" class="navBtn">
			<span class="material-icons">keyboard_double_arrow_left</span>
		</a>
        <?php include $_SERVER['DOCUMENT_ROOT']."/admin/include/gnb.php";?>
	</nav>
	