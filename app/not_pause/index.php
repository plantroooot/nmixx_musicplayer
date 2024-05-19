<?php
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
                    <div class="sub-gnb sub-gnb1">
                        <ul>
                            <li>
                                <a href="javascript:;" class="on">
                                    <div class="con automate">
                                        <em class="ico">
                                            <img src="/img/automate.png" alt="automate">
                                        </em>
                                        <span>Automate</span>
                                    </div>
                                </a>
                            </li>                            
                            <li>
                                <a href="javascript:;">
                                    <div class="con apple">
                                        <em class="ico">
                                            <img src="/img/apple.jpg" alt="apple">
                                        </em>
                                        <span>iOS 단축어</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="cont-area">
                        <div class="img-area">
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/automate_guide.jpg" alt="Automate">
                                </div>
                            </div>
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/ios_music_guide.jpg" alt="iOS 단축어">
                                </div>
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