<?php

// 레퍼러 주소체크
function checkReferer($referer) {
	$result = true;
	if (CHECK_REFERER) {
		if (!strpos($referer,REFERER_URL)) {
			$result = false;
		}
	}
	return $result;
}

?>