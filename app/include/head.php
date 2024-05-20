<?
include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/seo/Seo.class.php";

$_REQUEST['user'] = 1;
$seo = new Seo(99999, 'seo', $_REQUEST, 'seo_id');
$seo_result = $seo->getList($_REQUEST);

$url = $_SERVER['REQUEST_URI'];
$seo_data = $seo->getDataFromUrl($url);

?>
<!doctype html>
<html lang="ko">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta charset="utf-8">
    <link rel="canonical" href=""/>
    <title><?=COMPANY_NAME?></title>
    <meta name="url" content="">
    <meta name="author" content=" <?=COMPANY_NAME?>">
    <meta name="name" content="<?=COMPANY_NAME?>">
    <meta name="type" content="website">
    <!-- <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no"> -->
    <?php if(MobileCheck() > 0) {?>
    <meta name="viewport" content="width=640, user-scalable=0">
    <?php } else { ?>
    <meta name="viewport" content="width=1920, user-scalable=0">
    <?php } ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no, address=no, email=no">
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="image" content="<?=COMPANY_URL?>/img/og_img.jpg">
    <!-- opengraph -->
    <meta property="og:url" content="">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:keywords" content="">
    <meta property="og:image" content="<?=COMPANY_URL?>/img/og_img.jpg"/>
    <meta itemprop="image" content="<?=COMPANY_URL?>/img/og_img.jpg">
    <meta name="og:type" charset=""content="website"/>
    <meta name="image:width"content="800"/>
    <meta name="image:height" content="400"/>
    <!-- //opengraph -->
<link itemprop="url" href="">
<a itemprop="sameAs" href=""></a>
</span>

    <link rel="canonical" href=""/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    
    <!-- Styles -->
    <link rel="stylesheet" href="/css/reset.css?v=<?=time()?>">
    <link rel="stylesheet" href="/css/component.css?v=<?=time()?>">
    <link rel="stylesheet" href="/css/content.css?v=<?=time()?>">
    <link rel="stylesheet" href="/css/responsive.css?v=<?=time()?>">

    <!-- scripts -->
    <script src="/js/jquery-1.12.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/common.js"></script>

</head>

<body>
<div class="wrapper">


