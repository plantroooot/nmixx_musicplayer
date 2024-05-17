<?php
header("X-Powered-By: ");
header("Server: ");
header("Content-Type: ");
header("Connection: ");

if(!isset($_SESSION)) 
{ 
   session_start(); 
} 
header("Content-Type: text/html; charset=UTF-8");
$request_check=0;
$_SESSION['SECURITY_LEVEL']=0;
if($request_check != 1 && $_SESSION['SECURITY_LEVEL'] == 3)
{
	unset($arr_request);
	unset($arr_post);
	unset($arr_get);
	unset($arr_illegal);
	unset($arr_replaced);

	$arr_request = $_REQUEST;
	$arr_post = $_POST;
	$arr_get = $_GET;

	reset($arr_request);
	reset($arr_post);
	reset($arr_get);

	/** 한글 표현 때문에 ; 를 무조건 제거: semi-colon 사용하기 위해서 |mMm|59 라고 치환하시면 됩니다. **/
	$arr_illegal = array("&#",";","#","&","|mMm|59","|mMm|#35;","--","/*","*/","<",">","(",")","|mMm|special",'\"',"\'","'","document","cookie","script"," onload","xp_","1=1","passwd","iframe"," onerror"," onmouse"," onkey"," onclick"," oncontextmenu"," ondblclick"," ondragstart"," onreadystatechange");
	$arr_replaced = array("|mMm|special","","|mMm|#35;","&#38;","&#59;","&#34;","&#45;&#45;","","","&lt;","&gt;","&#40;","&#41;","&#","","","","do_cument","co_okie","sc_ript"," on_load","x_p_","1_=1","pass_wd","i_frame"," on_error"," on_mouse"," on_key"," on_click"," on_contextmenu"," on_dblclick"," on_dragstart"," on_readystatechange");

	$arr_request = str_ireplace($arr_illegal,$arr_replaced,$arr_request);
	$arr_post = str_ireplace($arr_illegal,$arr_replaced,$arr_post);
	$arr_get = str_ireplace($arr_illegal,$arr_replaced,$arr_get);

	$_REQUEST = $arr_request;
	$_POST = $arr_post;
	$_GET = $arr_get;

	unset($arr_request);
	unset($arr_post);
	unset($arr_get);
	unset($arr_illegal);
	unset($arr_replaced);

	$request_check = 1;
}
$mycookie = $_COOKIE;
$mysession = $_SESSION;


include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/MySecurity.php";

$security = new MySecurity();
$mycookie = $security->xss_clean($mycookie);
$mysession = $security->xss_clean($mysession);

unset($security);

// castle적용
//include_once($_SERVER['DOCUMENT_ROOT']."/include/castle.php");

// $chatUse = false; //챗봇


$HostingInfo = true; //호스팅 만료정보 표기 siteproperty.php

if(!function_exists('SQLinjection')){// application/config/config.php 로딩 되었으면 건너뜀
	function SQLinjection($a){
		$SQL = array(
		'select','union','insert', 'update', 'delete', 'drop','limit' , 'md5', 'extractvalue', 'and','script','where','iframe','&#39;','&#38;','&#38;','&#40;','&#41;','&#60;','&#61;','&#62;','&#63;'
		);
		for($i=0;$i<sizeof($SQL);$i++) {
		$a = str_replace($SQL[$i], '' , $a);
		}
		return xss_clean_n($a);
	}

	function xss_clean_n($data)
	{
		$data = str_replace(array('&','<','>'), array('&amp;','&lt;','&gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
		do{
			$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		} while ($old_data !== $data);
		return $data;
	}
	function anti_sqlinjection() {
		foreach ($_POST as $k => $v) {
			if (is_array($v) == 1) {
				$_POST[$k] = $v;
			} else {
				$_POST[$k] = addslashes($v);
			}
		}
		foreach($_GET as $k => $v) {
			$_GET[$k] = addslashes($v);
		}
		foreach($_REQUEST as $k => $v) {
			if(is_string($v)){
				$_REQUEST[$k] = addslashes($v);
			}
		}
		foreach($_SERVER as $k => $v) {
			if(is_string($v))$_SERVER[$k] = addslashes($v);
		}
		foreach($_COOKIE as $k => $v) {
			$_COOKIE[$k] = addslashes($v);
		}
	}
	function SQL_chk($str){
		$SQL = array(
		'select','union','insert', 'update', 'delete', 'drop', 'limit', 'and','script','where','iframe','&#39;','&#38;','&#38;','&#40;','&#41;','&#60;','&#61;','&#62;','&#63;'
		);
		$str_n=0;

		for($i=0;$i<sizeof($SQL);$i++) {
			if(is_array($str) == 1) {
				$str_n += 0;
			}else{
				$str_n += substr_count($str,$SQL[$i]);
			}
		}
		return $str_n;
	}
	
	anti_sqlinjection();

	$SQLinjection_chk = '/(select|union|insert|update|delete|drop|limit|and|=|script|where|iframe)/i';
	$SQLinjection_true = 0;
	$sql_in_num = 1; //sqlinjection에 두개이상 단어가 들어가면 모든 변수값 해당 단어 삭제

	foreach($_POST as $k => $v) {
				$SQLinjection_true = SQL_chk($_POST[$k]);
					if($SQLinjection_true>$sql_in_num ){
							$_POST[$k] = SQLinjection($_POST[$k]);
					}
				$SQLinjection_true = 0;
	}

	foreach($_GET as $k => $v) {
				$SQLinjection_true = SQL_chk($_GET[$k]);
					if($SQLinjection_true>$sql_in_num ){
							$_GET[$k] = SQLinjection($_GET[$k]);
					}
				$SQLinjection_true = 0;
	}

	foreach($_REQUEST as $k => $v) {
				$SQLinjection_true = SQL_chk($_REQUEST[$k]);
					if($SQLinjection_true>$sql_in_num ){
							$_REQUEST[$k] = SQLinjection($_REQUEST[$k]);
					}
				$SQLinjection_true = 0;
	}
}
?>