<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	include_once $root."/include/head.php";
?>

<script>
	$(function(){
		$('.mo-btn input[type="checkbox"]').on('change', function(){
			let checked = $(this).is(':checked');
			// console.log(checked);
			if(checked){
				$('#header .gnb-wrap').slideDown(400);
				$('.mo-bg').fadeIn(400);
			}else{
				$('#header .gnb-wrap').slideUp(400);
				$('.mo-bg').fadeOut(400);
			}
		});
	});
</script>

<header id="header" class="wide">
	<div class="header-body">
		<div class="header-inner flex-box justify-content-between">
			<div class="logo-wrap">
				<h1>
					<a href="/" class="blind"><?php echo COMPANY_NAME; ?></a>
				</h1>	
			</div>
			<div class="gnb-wrap">
				<ul>
					<?
						/*
						| ----------------------------------------------------------------------------------------
						| depth1
						| ----------------------------------------------------------------------------------------
						*/
						if($seo_result){
							foreach($seo_result as $key => $seorow){
					?>
						<li>
							<a href="<?php echo $seorow['seo_url']?>"><?php echo $seorow['seo_name']?></a>
						</li>
					<?
						}
					
					}
					?>
				</ul>
				<!-- <div class="util-wrap-mo">
					<ul>
						<li>
							<a href="/" class="on">KOR</a>
						</li>
						<li>
							<a href="/en/">ENG</a>
						</li>
					</ul>
				</div> -->

			</div>
			<!-- <div class="util-wrap util-wrap-pc">
				<ul>
					<li>
						<a href="/" class="on">KOR</a>
					</li>
					<li>
						<a href="/en/">ENG</a>
					</li>
				</ul>
			</div> -->
			<div class="mo-btn">
				<div class="mo-btn-inner">
					<input type="checkbox" id="hamburger">
					<label for="hamburger">
						<span></span>
						<span></span>
						<span></span>
					</label>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="mo-bg"></div>

