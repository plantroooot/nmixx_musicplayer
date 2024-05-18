<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	include_once $root."/include/head.php";
?>

<header id="header" class="wide">
	<div class="header-body">
		<div class="header-inner flex-box justify-content-between">
			<div class="logo-wrap">
				<h1>
					<a href="/" class="blind">로고영역</a>
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
		
			</div>
			<div class="util-wrap">
				<ul>
					<li>
						<a href="/">KOR</a>
					</li>
					<li>
						<a href="/en/">ENG</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>

