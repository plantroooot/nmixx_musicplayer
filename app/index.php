<?php
include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Rank.class.php";


$rank = new Rank(1, 'rank', $_REQUEST);
$rowPageCount1 = $rank->getRankCount($_REQUEST, 1);
$result1 = $rank->getRankList($_REQUEST, 1);

$rowPageCount2 = $rank->getRankCount($_REQUEST, 2);
$result2 = $rank->getRankList($_REQUEST, 2);

include_once $_SERVER['DOCUMENT_ROOT']."/header.php";
?>
 
<style>
	
</style>

<main id="main">
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
</main>
<script>
	$('#rankTab ul li a').on('click', function(){
		let idx = $(this).parent().index();

		$(this).parent().siblings().children('a').removeClass('on');
		$('.tbl_area .tbl_wrap').css('display', 'none');
		$(this).addClass('on');
		$('.tbl_area .tbl_wrap').eq(idx).css('display', 'block');

		console.log(idx);
	});
</script>

<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
?>