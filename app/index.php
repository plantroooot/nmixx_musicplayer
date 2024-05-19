<?php
include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";


include_once $_SERVER['DOCUMENT_ROOT']."/header.php";


?>
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
	$(function(){
		var swiper = new Swiper(".vote-swiper", {	
		spaceBetween: 30,
		scrollbar: {
			el: ".swiper-scrollbar",
			hide: false,
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
					<img src="/img/main_visual2.jpg" alt="DASH">
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
				<div class="section-half-wrap flex-box">
					<div class="section-half">
						<div class="tit-area clear">
							<div class="tit-box">
								<h2 class="gd-dot">Vote to NMIXX</h2>
								<span>진행중인 투표</span>						
							</div>		
						</div>
						<div class="cont-area">
							<div class="slide-area">
								<div class="swiper vote-swiper">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<div class="swiper-box">
												<a href="">
													<div class="swiper-cont">
														<div class="vote-title">
															<h3>투표1</h3>
															<span>2024-05-13 ~ 2024-08-07</span>
														</div>
														<div class="vote-content">
															test
														</div>
													</div>
												</a>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="swiper-box">
												<a href="">
													<div class="swiper-cont">
														<div class="vote-title">
															<h3>투표1</h3>
															<span>2024-05-13 ~ 2024-08-07</span>
														</div>
														<div class="vote-content">
															test
														</div>
													</div>
												</a>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="swiper-box">
												<a href="">
													<div class="swiper-cont">
														<div class="vote-title">
															<h3>투표1</h3>
															<span>2024-05-13 ~ 2024-08-07</span>
														</div>
														<div class="vote-content">
															test
														</div>
													</div>
												</a>
											</div>
										</div>
									</div>
									<div class="swiper-scrollbar"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="section-half">
						<a class="twitter-timeline" href="https://twitter.com/NMIXX_xstream?ref_src=twsrc%5Etfw" height="328">Tweets by NMIXX_xstream</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
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
	include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
?>