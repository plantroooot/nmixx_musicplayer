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
                                    <div class="con ico_making_id">
                                        <em class="ico">
                                            <img src="/img/ico_making_id.png" alt="ico_making_id">
                                        </em>
                                        <span>아이디 생성</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="con melon">
                                        <em class="ico">
                                            <img src="/img/melon.png" alt="melon">
                                        </em>
                                        <span>멜론 아이디</span>
                                    </div>
                                </a>
                            </li>                            
                            <li>
                                <a href="javascript:;">
                                    <div class="con ico_streaming_choice">
                                        <em class="ico">
                                            <img src="/img/ico_streaming_choice.png" alt="ico_streaming_choice">
                                        </em>
                                        <span>음싸 선택</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="con ico_radio_broadcast">
                                        <em class="ico">
                                            <img src="/img/ico_radio_broadcast.png" alt="ico_radio_broadcast">
                                        </em>
                                        <span>라디오</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="con ico_have_to_do">
                                        <em class="ico">
                                            <img src="/img/ico_have_to_do.png" alt="ico_have_to_do">
                                        </em>
                                        <span>비활기</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="cont-area">
                        <div class="img-area">
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/making_id.png" alt="아이디생성 가이드">
                                </div>
                            </div>
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/making_melon_id.jpg" alt="멜론아이디 생성 가이드">
                                </div>
                            </div>
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/streaming_choice_guide.png" alt="음싸 선택 가이드">
                                </div>
                            </div>
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/radio_guide.png" alt="라디오 신청 가이드">
                                </div>
                            </div>
                            <div class="img-wrap img-wrap1">
                                <div class="imgs">
                                    <img src="/img/have_to_do.png" alt="비활기 가이드">
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