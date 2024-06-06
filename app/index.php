<?php
include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Post.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/OfficialInfo.class.php";


include_once $_SERVER['DOCUMENT_ROOT']."/header.php";

$post = new Post(99999, 'post', $_REQUEST);
$prowPageCount = $post->getCount($_REQUEST);
$presult = $post->getListAll($_REQUEST);

// 진행중인 투표
$vote_result = [];
foreach ($presult as $item) {
    if ($item['brd_code'] === 'vote') {
        $vote_result[] = $item;
    }
}

// 공지사항
$notice_result = [];
foreach ($presult as $item) {
    if ($item['brd_code'] === 'notice') {
        $notice_result[] = $item;
    }
}

$official = new OfficialInfo(9999, 'official_info', $_REQUEST);
$oresult = $official->getList($_REQUEST);

include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/mainPopup.php";

?>
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
	$(function(){
		var swiper = new Swiper(".vote-swiper", {
			slidesPerView : 1,
			spaceBetween: 15,
			scrollbar: {
				el: ".swiper-scrollbar",
				hide: false,
			},
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
			},
		})
	});
</script>
<style>
	
</style>

<main id="main">
	<section class="main-visual">
		<div class="visual-area">
			<div class="visual-wrap">
				<a href="https://youtu.be/7UecFm_bSTU" target="_blank">					
					<img src="/img/main_visual2.jpg" alt="DASH" class="visual-pc">				
					<img src="/img/main_visual_mo2.jpg" alt="DASH" class="visual-mo">
					<div class="txt-wrap">
						<p class="txt">
							Fe3O4 : BREAK<br>
							<span>DASH</span>
						</p>
					</div>
				</a>
			</div>
		</div>
	</section>
	<section class="section section1">
		<div class="section-wrap">
			<div class="size">
				<div class="section-half-wrap clear">
					<div class="section-half">
						<div class="section-shadow">
							<div class="tit-area clear">
								<div class="tit-box">
									<h2 class="gd-dot">Vote for NMIXX</h2>
									<span>현재 진행중인 투표 목록입니다</span>						
								</div>		
							</div>
							<div class="cont-area">
								<div class="slide-area">
									<div class="swiper vote-swiper">
										<div class="swiper-wrapper">
											<?php 
												if($vote_result){
													foreach($vote_result as $key => $vrow){
													$vpost_links = json_decode($vrow['post_links'], true);
											?>
											<div class="swiper-slide">
												<div class="swiper-box">
													<a href="<?php echo $vpost_links[0] ? $vpost_links[0] : 'javascript:;'; ?>" <?php echo $vpost_links[0] ? "target='_blank'" : ''; ?>>
														<div class="swiper-cont" style="background: <?php echo getGradation($key+1); ?>">
															<div class="vote-title">
																<h3><?php echo $vrow['post_title']; ?></h3>
																<span><?php echo getYMD($vrow['post_startdate'])?> ~ <?php echo getYMD($vrow['post_enddate'])?></span>
															</div>
															<div class="vote-content">
																<?php echo $vrow['post_contents']; ?>
															</div>
														</div>
													</a>
												</div>
											</div>
											<?php
												}
											}

											if(! $vote_result ){
												
											?>
											<div class="swiper-slide">
												<div class="swiper-box">현재 진행중인 투표가 없습니다.</div>
											</div>
											<?php } ?>
										</div>
										<div class="swiper-scrollbar"></div>
									</div>
								</div>
							</div>
						</div>
					</div>					
					<div class="section-half notice-section">
						<div class="section-shadow">
							<div class="tit-area clear">
								<div class="tit-box">
									<h2 class="gd-dot">공지사항</h2>
									<span>음원총공팀 공지사항 입니다.</span>
								</div>
							</div>
							<div class="cont-area scroll-wrap">
								<ul>
									<?php 
										if($notice_result){
											$_REQUEST['bcode'] = 'notice';
											foreach($notice_result as $key => $nrow){
											$targetUrl = $post->getQueryString('/post/view.php', $nrow['post_id'], $_REQUEST);
										if($key == 0){									
									?>
									<li>
										<a href="<?php echo $targetUrl; ?>">
											<div class="notice-item">
												<div class="notice-header">
													<span class="notice-title"><?php echo $nrow['post_title']?></span>
													<span class="notice-date"><?php echo getYMD($nrow['post_datetime'])?></span>
												</div>
												<div class="notice-body">
													<?php echo $nrow['post_contents']?>
												</div>
											</div>
										</a>
									</li>									
									<?php
										}else{
									?>									
									<li>
										<a href="<?php echo $targetUrl; ?>">
											<div class="notice-item">
												<div class="notice-header">
													<span class="notice-title"><?php echo $nrow['post_title']?></span>
													<span class="notice-date"><?php echo getYMD($nrow['post_datetime'])?></span>
												</div>
											</div>
										</a>
									</li>
									<?php
											}
										}
									}

									if(! $vote_result ){
										
									?>
									<li>
										<a href="javascript:;">
											<div class="notice-item">
												<div class="notice-header">
													<span class="notice-title">등록된 공지사항이 없습니다.</span>
												</div>
											</div>
										</a>
									</li>
									<?php } ?>
								</ul>



								<?/*
								<a href="" class="">
									<div class="notice-item">
										<div class="notice-header">
											<span class="notice-title">[공지] 음원총공 팀의 공지사항입니다.</span>
											<span class="notice-date">2024/06/01</span>
										</div>
									</div>
								</a>
								*/?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section section2">
		<div class="section-wrap">
			<div class="size">
				<div class="section-half-wrap flex-box">
					<div class="section-half left-wrap">
						<div class="section-shadow">
							<div class="tit-area clear">
								<div class="tit-box">
									<h2 class="gd-dot">원클릭 스밍(Korea)</h2>
									<span>한번의 클릭으로 다양한 서비스를 이용해보세요</span>		
								</div>		
							</div>
							<div class="cont-area">
								<div class="list-wrap">
									<ul>
										<li>
											<a href="javascript:;" onclick="openPopup('melonOneClick');">
												<div class="box melon">
													<div class="txt">
														<p>
															<span class="arrow">→</span>
															<b>
																멜론<br/>
																원클릭<br/>
																스트리밍
															</b>
														</p>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="javascript:;" onclick="openPopup('genieOneClick');">
												<div class="box geine">
													<div class="txt">
														<p>
															<span class="arrow">→</span>
															<b>
																지니<br/>
																원클릭<br/>
																스트리밍
															</b>
														</p>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="javascript:;" onclick="openPopup('bugsOneClick');">
												<div class="box bugs">
													<div class="txt">
														<p>
															<span class="arrow">→</span>
															<b>
																벅스<br/>
																원클릭<br/>
																스트리밍
															</b>
														</p>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="javascript:;" onclick="openPopup('vibeOneClick');">
												<div class="box vibe">
													<div class="txt">
														<p>
															<span class="arrow">→</span>
															<b>
																바이브<br/>
																원클릭<br/>
																스트리밍
															</b>
														</p>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="https://www.melon.com/buy/meloncash/charge.htm" target="_blank">
												<div class="box melon">
													<div class="txt">
														<p>
															<span class="arrow">→</span>
															<b>
																멜론<br/>
																캐시💵<br/>
																충전하기
															</b>
														</p>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="javascript:;" onclick="openPopup('radioSmsApply');">
												<div class="box radio">
													<div class="txt">
														<p>
															<span class="arrow">→</span>
															<b>
																라디오<br/>
																문자📻<br/>
																신청하기
															</b>
														</p>
													</div>
												</div>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="section-half right-wrap">
						<div class="top-area">
							<div class="section-shadow">
								<div class="tit-area clear">
									<div class="tit-box">
										<h2 class="gd-dot">원클릭 스밍(Global)</h2>
										<span>한번의 클릭으로 다양한 서비스를 이용해보세요</span>		
									</div>		
								</div>
								<div class="cont-area">
									<div class="list-wrap">
										<ul>
											<li>
												<a href="https://music.apple.com/kr/playlist/%EC%8A%A4%ED%8A%B8%EB%A6%AC%EB%B0%8D/pl.u-11zBJ7ohNEMzG0X" target="_blank">
													<div class="box apple_music">
														<div class="txt">
															<p>
																<span class="arrow">→</span>
																<b>
																	애플뮤직<br/>
																	원클릭<br/>
																	스트리밍
																</b>
															</p>
														</div>
													</div>
												</a>
											</li>
											<li>
												<a href="https://open.spotify.com/playlist/30YICu0zxuwFvZHMUOU1M2?si=dafbebadc08848a9" target="_blank">
													<div class="box spotify">
														<div class="txt">
															<p>
																<span class="arrow">→</span>
																<b>
																	스포티파이<br/>
																	원클릭<br/>
																	스트리밍
																</b>
															</p>
														</div>
													</div>
												</a>
											</li>
											<li>
												<a href="https://music.youtube.com/playlist?list=PLJMJ3Y2SILZS_KJD7i8DFILiTkdEZk4ds" target="_blank">
													<div class="box youtube_music">
														<div class="txt">
															<p>
																<span class="arrow">→</span>
																<b>
																	유튜브<br/>
																	원클릭<br/>
																	스트리밍
																</b>
															</p>
														</div>
													</div>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="btm-area">
							<div class="section-shadow">
								<div class="tit-area clear">
									<div class="tit-box">
										<h2 class="gd-dot">NMIXXX OFFICIAL</h2>
										<span>NMIXX 공식 계정입니다</span>		
									</div>		
								</div>
								<div class="cont-area">
									<div class="sns-list">
										<ul class="clear">											
											<?
												if($oresult){
													foreach($oresult as $key => $orow){
											?>
												<li>
													<a href="<?php echo $orow['ofi_url'] ?  $orow['ofi_url'] : 'javascript:;'; ?>" <?php echo $orow['ofi_url'] ? "target='_blank'" : ''; ?>>
														<div class="ico">
															<img src="/img/<?php echo getSNSIcon($orow['ofi_type']); ?>" alt="<?php echo getSNSType($orow['ofi_type']); ?>">
														</div>
														<?php if($orow['ofi_etc']) {?>
														<div class="txt">(<?php echo $orow['ofi_etc']; ?>)</div>
														<?php } ?>
													</a>
												</li>
											<?php  
													}
												}
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<?/*
	<div class="title-wrap">
		<h1>MIXX PLAYER</h1>
	</div>
	<div class="cont-wrap">
		<div class="size">
			<div id="rankTab" class="tab">
				<ul class="clear">
					<li>
						<a href="javascript:;" class="on">TOP 100</a>
					</li>
					<li>
						<a href="javascript:;">HOT 100</a>
					</li>
				</ul>
			</div>
			<div class="tbl_area">
				<div class="tbl_wrap">
					<table>
						<caption>멜론 TOP100</caption>
						<colgroup>
							<col width="80px" />
							<col width="*" />
							<col width="120px" />
							<col width="120px" />
						</colgroup>
						<thead>
							<tr>
								<th>순위</th>
								<th>곡정보</th>
								<th>앨범</th>
								<th>발매일</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?if($rowPageCount1 == 0){?>
								<tr>
									<td>등록된 순위가 없습니다.</td>
								</tr>
								<?
								}else{
									foreach($result1 as $key => $value){
								?>
								<td><?=$value['rank']?></td>
								<td>
									<div class="info_wrap">
										<div class="img back_img" style="background-image: url('<?=$value['thumbnail']?>');">
											<img src="/img/sample_album.jpg" alt="<?=$value['album']?>" class="basic_img">
										</div>
										<div class="info">
											<strong class="song_title"><?=$value['title']?></strong>							
											<span class="artist"><?=$value['artist']?></span>
										</div>
									</div>
								</td>
								<td><?=$value['album']?></td>
								<td><?=$value['release']?></td>
							</tr>
							<?}}?>
						</tbody>
					</table>
				</div>
				<div class="tbl_wrap">
					<table>
						<caption>멜론 HOT100</caption>
						<colgroup>
							<col width="80px" />
							<col width="*" />
							<col width="120px" />
							<col width="120px" />
						</colgroup>
						<thead>
							<tr>
								<th>순위</th>
								<th>곡정보</th>
								<th>앨범</th>
								<th>발매일</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?if($rowPageCount2 == 0){?>
								<tr>
									<td>등록된 순위가 없습니다.</td>
								</tr>
								<?
								}else{
									foreach($result2 as $key => $value){
								?>
								<td><?=$value['rank']?></td>
								<td>
									<div class="info_wrap">
										<div class="img back_img" style="background-image: url('<?=$value['thumbnail']?>');">
											<img src="/img/sample_album.jpg" alt="<?=$value['album']?>" class="basic_img">
										</div>
										<div class="info">
											<strong class="song_title"><?=$value['title']?></strong>							
											<span class="artist"><?=$value['artist']?></span>
										</div>
									</div>
								</td>
								<td><?=$value['album']?></td>
								<td><?=$value['release']?></td>
							</tr>
							<?}}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	*/?>
</main>
<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/melon_oneclick.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/genie_oneclick.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/bugs_oneclick.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/vibe_oneclick.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/radio_sms_apply.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
?>