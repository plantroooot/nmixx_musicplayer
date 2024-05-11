<ul class="gnb clearfix">
    <li class="parent"><a href="/admin/dashboard/"><span class="material-icons icon">space_dashboard</span>대시보드</a>
    <li class="parent"><a href="javascript:;"><span class="material-icons icon">forum</span>문의관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
           <!-- <li><a href="/admin/cscenter/reply2/" class="menu">답변게시판</a><a href="javascript:;" class="material-icons star"><?= in_array("답변게시판", $arr) ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/cscenter/consult/" class="menu">온라인상담</a><a href="javascript:;" class="material-icons star"><?= in_array("온라인상담", $arr) ? "star" : "star_outline" ?></a></li>-->
            <li><a href="/admin/cscenter/formmail/" class="menu">문의관리</a><a href="javascript:;" class="material-icons star"><?= in_array("문의관리", $arr) ? "star" : "star_outline" ?></a></li>
        </ul>
    </li>
	<li class="parent"><a href="javascript:;"><span class="material-icons icon">list_alt</span>파트너사관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <li><a href="/admin/board/?bname=partners" class="menu">파트너사 관리</a><a href="javascript:;" class="material-icons star"><?=in_array("파트너사 관리", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/history/" class="menu">History</a><a href="javascript:;" class="material-icons star"><?=in_array("History", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/board/?bname=testimonials" class="menu">Testimonials</a><a href="javascript:;" class="material-icons star"><?=in_array("Testimonials", $arr) == true ? "star" : "star_outline" ?></a></li>
        </ul>
    </li> 
     <li class="parent"><a href="javascript:;"><span class="material-icons icon">list_alt</span>게시판관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <?php if($_SESSION['admin_grade'] == 0){ ?>
            <li><a href="/admin/board_setup/index.php" class="menu">게시판관리</a><a href="javascript:;" class="material-icons star"><?= in_array("게시판관리", $arr) ? "star" : "star_outline" ?></a></li>
            
            <? while($row = mysqli_fetch_assoc($bdsresult)){ ?>
             <li><a href="/admin/board/?bname=<?=$row['P_code']?>" class="menu"><?=$row['P_title']?></a><a href="javascript:;" class="material-icons star"><?= in_array($row['P_title'], $arr) ? "star" : "star_outline" ?></a></li>
            <?php 
                } 
            } else {
            ?>
            <li><a href="/admin/board/?bname=news" class="menu">NEWS</a><a href="javascript:;" class="material-icons star"><?=in_array("NEWS", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/board/?bname=faq" class="menu">FAQ</a><a href="javascript:;" class="material-icons star"><?=in_array("FAQ", $arr) == true ? "star" : "star_outline" ?></a></li>
            <?}?>
        </ul>
    </li>
	<li class="parent"><a href="javascript:;"><span class="material-icons icon">forum</span>SEO관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <li><a href="/admin/seo/" class="menu">메뉴 관리</a><a href="javascript:;" class="material-icons star"><?=in_array("메뉴 관리", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/seo/settings/" class="menu">SEO 설정 관리</a><a href="javascript:;" class="material-icons star"><?=in_array("SEO 설정 관리", $arr) == true ? "star" : "star_outline" ?></a></li>
        </ul>
    </li>    
    <li class="parent"><a href="javascript:;"><span class="material-icons icon">web</span>사이트관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <!--<li><a href="/admin/site/mainimg/" class="menu">메인비주얼 관리</a><a href="javascript:;" class="material-icons star"><?=in_array("메인비주얼 관리", $arr) == true ? "star" : "star_outline" ?></a></li>-->
            <li><a href="/admin/site/popup/" class="menu">팝업관리</a><a href="javascript:;" class="material-icons star"><?=in_array("팝업관리", $arr) == true ? "star" : "star_outline" ?></a></li>
           <!-- <li><a href="/admin/site/spam/" class="menu">스팸단어관리</a><a href="javascript:;" class="material-icons star"><?=in_array("스팸단어관리", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/site/sms/" class="menu">SMS발송</a><a href="javascript:;" class="material-icons star"><?= in_array("SMS발송", $arr) ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/site/smslist/" class="menu">SMS발송 리스트</a><a href="javascript:;" class="material-icons star"><?= in_array("SMS발송 리스트", $arr) ? "star" : "star_outline" ?></a></li>-->
        </ul>
    </li>
    <!--<li class="parent"><a href="javascript:;"><span class="material-icons icon">person</span>회원관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <?php if($_SESSION['admin_grade'] == 0){ ?>
                <li><a href="/admin/member/setting.php" class="menu">회원관리설정</a></li>
            <?php } ?>
            <li><a href="/admin/member/" class="menu">회원관리</a><a href="javascript:;" class="material-icons star"><?=in_array("회원관리", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/member/secede_index.php" class="menu">탈퇴회원 관리</a><a href="javascript:;" class="material-icons star"><?=in_array("탈퇴회원 관리", $arr) == true ? "star" : "star_outline" ?></a></li>
        </ul>
    </li>-->
    <li class="parent"><a href="javascript:;"><span class="material-icons icon">manage_accounts</span>관리자관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <li><a href="/admin/manage/manager/" class="menu">관리자관리</a><a href="javascript:;" class="material-icons star"><?=in_array("관리자관리", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/manage/loginhistory/" class="menu">관리자 접속이력</a><a href="javascript:;" class="material-icons star"><?=in_array("관리자 접속이력", $arr) == true ? "star" : "star_outline" ?></a></li>
        </ul>
    </li>
    <li class="parent"><a href="javascript:;"><span class="material-icons icon">insert_chart_outlined</span>방문자 관리<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <li><a href="/admin/connect/" class="menu">유입내역</a><a href="javascript:;" class="material-icons star"><?=in_array("유입내역", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/connect/page/" class="menu">페이지내역</a><a href="javascript:;" class="material-icons star"><?=in_array("페이지내역", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/connect/keyword.php" class="menu">키워드 내역</a><a href="javascript:;" class="material-icons star"><?=in_array("키워드 내역", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/connect/monthly.php" class="menu">월별 내역</a><a href="javascript:;" class="material-icons star"><?=in_array("월별 내역", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/connect/rate/" class="menu">접속율 내역</a><a href="javascript:;" class="material-icons star"><?=in_array("접속율 내역", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/connect/rate/browser.php" class="menu">브라우저&amp;OS 내역</a><a href="javascript:;" class="material-icons star"><?=in_array("브라우저&OS 내역", $arr) == true ? "star" : "star_outline" ?></a></li>
            <li><a href="/admin/connect/country/" class="menu">접속국가 내역</a><a href="javascript:;" class="material-icons star"><?=in_array("접속국가 내역", $arr) == true ? "star" : "star_outline" ?></a></li>
        </ul>
    </li>
    <?/*
    <li class="parent"><a href="javascript:;"><span class="material-icons icon">insert_chart_outlined</span>관리자 기본 페이지<span class="material-icons arrow">keyboard_arrow_down</span></a>
        <ul>
            <li><a href="/admin/basic/" class="menu">관리자 기본 페이지</a><a href="javascript:;" class="material-icons star"><?=in_array("관리자 기본 페이지", $arr) == true ? "star" : "star_outline" ?></a></li>
        </ul>
    </li>
    */?>
</ul>