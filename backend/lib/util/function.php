<?php

// ���۷� �ּ�üũ
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