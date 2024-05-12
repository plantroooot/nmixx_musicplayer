<?php

include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";

// 메시지를 alert하고 rurl로 이동
function returnURLMsg($rurl = "", $msg = "") {
	$return = 
		"<script>
			alert('".$msg."');
			document.location.href='".$rurl."';
		</script>";
	return $return;
}

// 메시지를 alert하고 rurl로 이동
function returnURLMsgRefresh($rurl = "", $msg = "") {
	$return = 
		"<script>
			alert('".$msg."');
			opener.location.reload();
			document.location.href='".$rurl."';
		</script>";
	return $return;
}

// rurl로 이동
function returnURL($rurl = "") {
	$return = 
		"<script>
			document.location.href='".$rurl."';
		</script>";
	return $return;
}

// rurl로 이동 후 창을 닫는다.
function returnURLClose($rurl = "") {
	$return = 
		"<script>
			document.location.href='".$rurl."';
			window.close();
		</script>";
	return $return;
} 

// 메시지 alert, rurl로 이동 후 창을 닫는다.
function returnURLCloseMsg($rurl = "", $msg = "") {
	$return = 
		"<script>
			alert('".$msg."');
			document.location.href='".$rurl."';
			window.close();
		</script>";
	return $return;
}

// 메시지 alert 이전페이지로 이동
function returnHistory($msg = "") {
	$return = 
		"<script>
			alert('".$msg."');
			history.back();
		</script>";
	return $return;
}


// 파일사이즈를 계산해서 알맞은 단위로 변경한다.
function getFileSize($fileSize = 0) {
	$fSize = "";
	if ($fileSize > 1024 && ($fileSize < 1024*1024)) {
		$fSize = round(($fileSize/1024),2)."KB";
	} else if ($fileSize >= 1024*1024) {
		$fSize = round(($fileSize/(1024*1024)),2)."MB";
	} else {
		$fSize = $fileSize."Bytes";
	}
	return $fSize;
}

function xss_clean_value($data){
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);

	// we are done...


	return $data;
}
function xss_clean($req){ // html_decode 함수의 일종
		if(!empty($req))
		{
			if(!is_array($req)){
				$req = xss_clean_value($req);
			}else{

				foreach($req as $key => $value){

					if(!is_array($value)){
						$req[$key] = xss_clean_value($value);

					}else{

						foreach ($value as $innerKey => $innerValue) {
							$req[$key][$innerKey] = xss_clean_value($innerValue);
						}
					}
				}

			}
		}
        return $req;
}

//escape
function escape_string($req) {
	/*
    $reqKeyArray = array_keys($req);
    for ($i=0; $i<count($reqKeyArray); $i++) {
        $req[$reqKeyArray[$i]] = @addslashes($req[$reqKeyArray[$i]]);
    }
    return $req;
	*/
	
	if( !empty($req) ){

		foreach ($req as $key => $value) {

			if (!is_array($value)) {
				$req[$key] = $value;//mysqli_real_escape_string($value);
			} else {
				foreach ($value as $innerKey => $innerValue) {
					$req[$key][$innerKey] = $innerValue;//mysqli_real_escape_string($innerValue);
				}
			}
			
		}
	}
	return $req;
}


// 이미지사이즈 비교
// 실제 이미지 width값과 비교해서 작을 경우 reWidth값으로 리턴
function getImgReSize($img = "", $reWidth=0) {
	$r = 0;
	try {
		$info = getimagesize($_SERVER['DOCUMENT_ROOT'].$img);
		$size = substr($info[3], strpos($info[3], "\"")+1);
		$size = substr($size, 0, strpos($size, "\""));
		if ($size > $reWidth) {
			$r = $reWidth;
		} else {
			$r = $size;
		}
	} catch (Exception $e) {
		$r = 0;
	}

	return $r;
}


// SSL 사용여부 체크
function getSslCheckUrl($request_uri="", $page="") {

	$request_uri = substr($request_uri, 0, strrpos($request_uri, '/'));
	$url = COMPANY_URL;
	if (SSL_USE) $url = COMPANY_SSL_URL;

	$returnUrl = $url.$request_uri.'/'.$page;

	return $returnUrl;
}

// SSL 사용여부 체크 
// 심볼릭 링크 lib 가 모바일과 데스크탑경로가 같을 경우
// COMPANY_URL 을 
function getSslCheckUrl2($request_uri="", $page="") {

	$request_uri = substr($request_uri, 0, strrpos($request_uri, '/'));

	if( strlen(stristr($_SERVER["HTTP_HOST"], "m.ndental") ) ){
//	if( strlen(stristr($request_uri, "m.ndental") ) ){
		$url = COMPANY_M_URL;
	}else{
		$url = COMPANY_URL;
	}
	if (SSL_USE) $url = COMPANY_SSL_URL;

	$returnUrl = $url.$request_uri.'/'.$page;

	return $returnUrl;
}

// 페이지카운트
function getPageCount($pageRows=0, $totalCount=0) {
	$pageCount = $totalCount / $pageRows;
	if ($totalCount % $pageRows > 0) $pageCount++;
	return (int)$pageCount;
}

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

// https 주소 제거
function getRemoviSslUrl($request_uri='', $page='') {

	$request_uri = substr($request_uri, 0, strrpos($request_uri, '/'));
	$url = COMPANY_URL;
	
	$returnUrl = $url.$request_uri.'/'.$page;

	return $returnUrl;
}


function file_get_contents_curl($url) {
	if(strpos($url, "https://")){
		$url = str_replace("https://","http://", $url);
	}

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, $url);

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

// 파일명 변환 밀리세컨초_인코딩%제외
function getRandFileName($fileName='') {
	// 확장자가 실행파일인 경우 확장자에 -x를 붙임(웹실행방지 보안을 위해)
	$fileName = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc|cab|js)/i", "$0-x", $fileName);

	// 랜덤문자 3개 생성
	$shuffle = '';
	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
	$shuffle = implode("", $chars_array);
	$rand_char = "";
	if (strlen($shuffle)>0) { 
		for ($i=0; $i<3; $i++) {
			$rand_char .= $shuffle[mt_rand(0,strlen($shuffle))];
		}
	}
	$result = round(microtime(true))."_".$rand_char."_".str_replace('%', '', urlencode(str_replace(' ', '_', $fileName)));
	return $result;
}

/* 
로그 출력 
/www/log 파일 생성
권한필요
파일명은 날짜별로 생성
사용여부는 siteProperty.php의 IS_LOGFILE 변수 true시 적용
한글깨질 시 웹사이트 페이지 캐릭터셋과 서버 캐릭터셋 확인 후 siteProperty.php 변경
*/

function outlog($message) {
	if(is_array($message)){
		$message = iconv(LOG_PAGE_CHAR, LOG_SERVER_CHAR, print_r($message, true));	// 인코딩 필요
	} else {
		$message = iconv(LOG_PAGE_CHAR, LOG_SERVER_CHAR, $message);	// 인코딩 필요
	}
	
	$filename = date('Y-m-d').LOG_FILENAME;
	$p = pathinfo($_SERVER['PHP_SELF']);
	$location = $p['dirname']."/".$p['basename'];
	$log = date('H:i:s')." ".$_SERVER['REMOTE_ADDR']." ".$location."\r\n".$message."\r\n";

	if (IS_LOGFILE) {
		 $f = fopen(LOG_PATH."/".$filename, "a");
		 fwrite($f, $log);
		 fclose($f);
	}

}

/*
파일 업로드 처리 함수
해당 첨부파일을 실파일명, 원파일명, 파일사이즈를 구해 $_REQUEST에 세팅 후 리턴
$filename : 첨부파일명, $req : $_REQUEST, $isSize : 사이즈 구하기, $maxSaveSize : 최대 파일사이즈(config.php)
파일사이즈 명명 규칙 : 파일명이 filename3인 경우 filesize3
*/
function fileupload($filename, $uploadFullPath, $req, $isSize, $maxSaveSize) {
	$file_ext = explode(".", strrev($filename)); // . 으로 구분
	$file_ext = strrev($file_ext[0]); 
	$file_ext = strtolower($file_ext); // 확장자명 소문자로 변환
	
	// 업로드 확장자 블랙리스트
	$black_list = array("html", "htm", "php", "js", "jsp", "asp", "HTML", "HTM", "PHP", "JS", "JSP", "ASP", "php-x", "PHP-X", "exe", "EXE");
	if(in_array($file_ext, $black_list)){
		echo "
			<script>
				alert('업로드 할 수 없는 파일 형식입니다.');
				window.location.replace('index.php');
			</script>";
		
	}else{

		$files = $_FILES[$filename];
		$tmp_name = $files['tmp_name'];
		
		if(!is_dir($uploadFullPath)){
			mkdir($uploadFullPath, 0707);
		}

		if ($tmp_name) {

			if ($files['size'] <= $maxSaveSize) {
			
				$org_name = $files['name'];
				$file_name = getRandFileName($org_name);
				if (!$files['error']) {
					move_uploaded_file($tmp_name, $uploadFullPath.$file_name);
				}

				// db insert value
				$req[$filename] = $file_name;
				$req[$filename.'_org'] = $org_name;
				if ($isSize) {
					$tmp = substr($filename, -1);
					if ((int)$tmp > 0) {
						$req['filesize'.$tmp] = $files['size'];
					} else {
						$req['filesize']=$files['size'];
					}
				}
			} else {
				echo "
				<script>
					alert('파일첨부 최대용량을 초과했습니다.');
					window.location.replace('index.php');
				</script>";
			}
		}


	return $req;

	}
}


/**
 * DB result 값 array 배열로 변경
 * @param unknown $rst
 * @return multitype:
 */
function rstToArray($rst){
	$arr = array();
	if($rst != null && mysqli_num_rows($rst) > 0){
		while($row = mysqli_fetch_assoc($rst)){
			array_push($arr, $row);
		}
	}
	return $arr;
}

/**
 * json_decode 거치면 json_array list 객체들은 obj형식으로 변형됨.
 * @param unknown $obj
 * @return multitype:
 */
function objToArray($obj){
	if(is_object($obj)){
		$obj = get_object_vars($obj);
	}
	
	if(is_array($obj)){
		return array_map(__FUNCTION__, $obj);
	} else {

		return $obj;
	}
}



?>