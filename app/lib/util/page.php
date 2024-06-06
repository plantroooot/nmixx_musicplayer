<?
/*
페이징 처리

 */

function pageList($reqPageNo=1, $pageCount=0, $listUrl="") {
	$pagenumber = 10;
	$startpage;
	$endpage;
	$curpage;

	// 파라미터가 없는 URL인 경우 뒤에 ?를 붙임
	if (strpos($listUrl, '?') == 0) $listUrl = $listUrl.'?';

	$strList = "";

	$startpage = (int)(($reqPageNo-1) / $pagenumber) * $pagenumber + 1;				// 시작페이지번호 구하기
	$endpage = (int)((($startpage-1) + $pagenumber) / $pagenumber) * $pagenumber;		// 마지막 페이지번호 구하기

	// 총페이지수가 계산된 마지막페이지 번호보다 작을경우 총페이지수가 마지막페이지번호
	if ($pageCount <= $endpage) {
	  $endpage = $pageCount;
	}

	$strList = "<ul class='paging'>";

	// 첫번째 페이지 인덱스 화면이 아닌경우
	if ($reqPageNo > $pagenumber) {
		$curpage = $startpage - 1;		// 시작페이지번호보다 1적은 페이지로 이동
		$strList = $strList."<li><a href='".$listUrl."reqPageNo=1' class='bt first'><<</a></li> ";
		$strList = $strList."<li><a href='".$listUrl."reqPageNo=".$curpage."' class='bt prev'><</a></li> ";
	}

	// 시작페이지번호부터 마지막페이지번호까지 출력
	$curpage = $startpage;
	while ($curpage <= $endpage) {
		if ($curpage == $reqPageNo) {
			$strList = $strList."<li><a href='javascript:;' class='num current'>".$reqPageNo."</a></li>";
		} else {
			$strList = $strList."<li><a href='".$listUrl."reqPageNo=".$curpage."' class='num'>".$curpage."</a></li>";
		}
		$curpage++;
	}

	// 뒤에 페이지가 더 있는 경우
	if ($pageCount > $endpage) {
		$curpage = $endpage+1;
		$strList = $strList."<li><a href='".$listUrl."reqPageNo=".$curpage."' class='bt next'><span class='material-icons'>arrow_forward_ios</span></a></li>";
		$strList = $strList."<li><a href='".$listUrl."reqPageNo=".$pageCount."' class='bt last'><span class='material-icons'>last_page</span></a></li>";
	}
	$strList = $strList."</ul>";

	return $strList;
}

function pageList2($reqPageNo=1, $pageCount=0, $listUrl="") {
	$pagenumber = 5;
	$startpage;
	$endpage;
	$curpage;

	// 파라미터가 없는 URL인 경우 뒤에 ?를 붙임
	if (strpos($listUrl, '?') == 0) $listUrl = $listUrl.'?';

	$strList = "";

	$startpage = (int)(($reqPageNo-1) / $pagenumber) * $pagenumber + 1;				// 시작페이지번호 구하기
	$endpage = (int)((($startpage-1) + $pagenumber) / $pagenumber) * $pagenumber;		// 마지막 페이지번호 구하기

	// 총페이지수가 계산된 마지막페이지 번호보다 작을경우 총페이지수가 마지막페이지번호
	if ($pageCount <= $endpage) {
	  $endpage = $pageCount;
	}

	$strList = "<div class=\"paginate flex wow fadeInUp\" data-wow-delay=\"0.2s\">";

	// 첫번째 페이지 인덱스 화면이 아닌경우
	if ($reqPageNo > $pagenumber) {
		$curpage = $startpage - 1;		// 시작페이지번호보다 1적은 페이지로 이동
		// $strList = $strList."<li><a href='".$listUrl."reqPageNo=1' class='board first'><span class='material-icons'>first_page</span></a></li> ";
		// $strList = $strList."<div class=\"paging paging_left\"><a href='".$listUrl."reqPageNo=1'><img src=\"/img/paging_left.png\" alt=\"이전페이지\"></a></div>";
		// $strList = $strList."<li><a href='".$listUrl."reqPageNo=".$curpage."' class='board prev'><span class='material-icons'>arrow_back_ios</span></a></li> ";
		$strList = $strList."<div class=\"paging paging_left\"><a href='".$listUrl."reqPageNo=".$curpage."'><img src=\"/img/paging_left.png\" alt=\"이전페이지\"></a></div>";
	}

	// 시작페이지번호부터 마지막페이지번호까지 출력
	$curpage = $startpage;
	$strList = $strList."<ul class=\"paing_num flex engtxt\">";
	while ($curpage <= $endpage) {
		if ($curpage == $reqPageNo) {
			$strList = $strList."<a href='javascript:;' class='active'>".$reqPageNo."</a>";
		} else {
			$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."'>".$curpage."</a>";
		}
		$curpage++;
	}
	$strList = $strList."</ul>";

	// 뒤에 페이지가 더 있는 경우
	if ($pageCount > $endpage) {
		$curpage = $endpage+1;
		$strList = $strList."<div class=\"paging paging_right\"><a href='".$listUrl."reqPageNo=".$curpage."'><img src=\"/img/paging_right.png\" alt=\"다음페이지\"></a></div>";
		// $strList = $strList."<li><a href='".$listUrl."reqPageNo=".$curpage."' class='board next'><span class='material-icons'>arrow_forward_ios</span></a></li>";
		// $strList = $strList."<li><a href='".$listUrl."reqPageNo=".$pageCount."' class='board last'><span class='material-icons'>last_page</span></a></li>";
	}
	$strList = $strList."</div>";

	return $strList;
}

function pageUserList($reqPageNo=1, $pageCount=0, $listUrl="") {
	$pagenumber = 10;
	$startpage;
	$endpage;
	$curpage;

	// 파라미터가 없는 URL인 경우 뒤에 ?를 붙임
	if (strpos($listUrl, '?') == 0) $listUrl = $listUrl.'?';

	$strList = "";

	$startpage = (int)(($reqPageNo-1) / $pagenumber) * $pagenumber + 1;				// 시작페이지번호 구하기
	$endpage = (int)((($startpage-1) + $pagenumber) / $pagenumber) * $pagenumber;		// 마지막 페이지번호 구하기

	// 총페이지수가 계산된 마지막페이지 번호보다 작을경우 총페이지수가 마지막페이지번호
	if ($pageCount <= $endpage) {
		$endpage = $pageCount;
	}

	$strList = "<div class=\"page_list\">";

	// 첫번째 페이지 인덱스 화면이 아닌경우
	if ($reqPageNo > $pagenumber) {
		$curpage = $startpage - 1;		// 시작페이지번호보다 1적은 페이지로 이동
		$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."'><img src='/images/page_arrow_1.gif' alt='이전' /></a> ";
	}

	// 시작페이지번호부터 마지막페이지번호까지 출력
	$curpage = $startpage;
	while ($curpage <= $endpage) {
		if ($curpage == $reqPageNo) {
			$strList = $strList."<a href='#' class='on'>".$reqPageNo."</a>";
		} else {
			$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."'>".$curpage."</a>";
		}
		$curpage++;
	}

	// 뒤에 페이지가 더 있는 경우
	if ($pageCount > $endpage) {
		$curpage = $endpage+1;
		$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."'><img src='/images/page_arrow_1.gif' alt='다음' /></a>";
	}
	$strList = $strList."</div>";

	return $strList;
}

function pageListMo($reqPageNo=1, $pageCount=0, $listUrl="") {
	$pagenumber = 10;
	$startpage;
	$endpage;
	$curpage;

	$strList = "";

	$startpage = (($reqPageNo-1) / $pagenumber) * $pagenumber + 1;				// 시작페이지번호 구하기
	$endpage = ((($startpage-1) + $pagenumber) / $pagenumber) * $pagenumber;		// 마지막 페이지번호 구하기

	// 총페이지수가 계산된 마지막페이지 번호보다 작을경우 총페이지수가 마지막페이지번호
	if ($pageCount <= $endpage) {
	  $endpage = $pageCount;
	}

	$strList = "<div class='page'>";

	// 첫번째 페이지 인덱스 화면이 아닌경우
	if ($reqPageNo > $pagenumber) {
		$curpage = $startpage - 1;		// 시작페이지번호보다 1적은 페이지로 이동
		$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."' class='next'><img src='/img/mo_list_prev.gif' alt='' />이전</a> ";
	}

	// 시작페이지번호부터 마지막페이지번호까지 출력
	$curpage = $startpge;
	while ($curpage <= $endpage) {
		if ($curpage == $reqPageNo) {
			$strList = $strList."<strong>".$reqPageNo."</strong>";
		} else {
			$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."' class='b_num'>".$curpage."</a.";
		}
		$curpage++;
	}

	// 뒤에 페이지가 더 있는 경우
	if ($pageCount > $endpage) {
		$curpage = $endpage+1;
		$strList = $strList."<a href='".$listUrl."reqPageNo=".$curpage."' class='next'>다음<img src='/img/mo_list_next.gif' alt=''/></a>";
	}
	$strList = $strList."</div>";

	return $strList;
}
?>