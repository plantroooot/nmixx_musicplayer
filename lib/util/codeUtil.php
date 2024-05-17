<?php

function getMVTitle($type){
	$result = "";
	
	if($type == 1) {
		$result = "O.O";
	} else if($type == 2) {
		$result = "DICE";
	} else if($type == 3) {
		$result = "Funky Glitter Christmas";
	} else if($type == 4) {
		$result = "Young, Dumb, Stupid";
	} else if($type == 5) {
		$result = "Love Me Like This";
	} else if($type == 6) {
		$result = "Roller Coaster";
	} else if($type == 7) {
		$result = "Party O’Clock";
	} else if($type == 8) {
		$result = "Soñar (Breaker)";
	}
	return $result;
}

function getSNSType($type){
	$result = "";
	
	if($type == 1) {
		$result = "유튜브";
	} else if($type == 2) {
		$result = "인스타그램";
	} else if($type == 3) {
		$result = "트위터";
	} else if($type == 4) {
		$result = "페이스북";
	} else if($type == 5) {
		$result = "틱톡";
	} else if($type == 6) {
		$result = "인스타그램";
	} else if($type == 7) {
		$result = "웨이보";
	}
	
	return $result;
}

function getNmember($type){
	$result = "";
	
	if($type == 1) {
		$result = "전체";
	} else if($type == 2) {
		$result = "릴리";
	} else if($type == 3) {
		$result = "해원";
	} else if($type == 4) {
		$result = "설윤";
	} else if($type == 5) {
		$result = "배이";
	} else if($type == 6) {
		$result = "지우";
	} else if($type == 7) {
		$result = "규진";
	}
	
	return $result;
}

function getNmemberToText($str){
	$array = explode(',', $str);
	$member_name = array();

	for($k = 0; $k < count($array); $k++){
		$member_name[$k] = getNmember($array[$k]);
	}

	$member_name = implode(',', $member_name);

	return $member_name;
	
}



function getScheduleTarget($type){
	$result = "";
	
	if($type == 1) {
		$result = "NMIXX";
	} else if($type == 2) {
		$result = "음원총공팀";
	} else if($type == 3) {
		$result = "기타";
	}
	
	return $result;
}


function getScheduleType($type){
	$result = "";
	
	if($type == 1) {
		$result = "방송";
	} else if($type == 2) {
		$result = "이벤트";
	} else if($type == 3) {
		$result = "생일";
	} else if($type == 4) {
		$result = "기타";
	} else if($type == 5) {
		$result = "유튜브";
	}
	
	return $result;
}

?>