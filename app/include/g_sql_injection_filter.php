<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
/*
* SQL INJECTION  üũ �ҽ�
* (��)����� �ۼ�
*/

/*************************** ���� ���� ��� ����  ***********************

1. �Ʒ� ������ �����Ͻø� �� ������ include�ϴ� ���Ͽ� ���������� �����̵˴ϴ�.

2. �⺻ ���� �������ɺκи� �ڵ� ��) �� ���Ŀ� �°� �����Ͻñ� �ٶ��ϴ�. �ڵ� ��)�� ���İ� Ʋ���� ASP ������ ���� �߻������� Ȩ�������� ������ �߻��Ҽ� �ֽ��ϴ�.

3. SQL INJECTION���� �����Ǵ� ������ ���Ϸ� �޾ƾ� �� ��� G_INJECTOIN_MAIL_ADDR ���� �����ּҸ� �� �����ؾ� �մϴ�.

**************************************************************************/


/************* ���� ���� ���� ���� ���� ����( (��)����� )  *************/
if ( trim($G_INJECTION_PATTERN_CHK) == "" ){
	$G_INJECTION_PATTERN_CHK = "Y" ;         //<-- �������ɺκ� : �⺻�� Y, Y - injection ���� ������ üũ��,    N - ���α׷��� ������� 
									        //    �ڵ� ��) G_INJECTION_PATTERN_CHK = "N"
}

if ( trim($G_INJECTOIN_MAIL_SEND) == "" ){
	$G_INJECTOIN_MAIL_SEND = "Y" ;           //<-- �������ɺκ� : �⺻�� Y, Y - injectoin ���� ������ üũ�� ��� ���Ϻ���,  N - ���� �� ����
											//    �ڵ� ��) G_INJECTOIN_MAIL_SEND = "N"
}

if ( trim($G_INJECTOIN_MAIL_ADDR) == "" ){
	$G_INJECTOIN_MAIL_ADDR = "Y" ;           //<-- �������ɺκ� : G_INJECTOIN_MAIL_SEND ���� Y�� ��� G_INJECTOIN_MAIL_ADDR ������ 
									        //                   SEQ INJECTION ������ ������
											//	   �ڵ� ��1) �޴� �����ּҰ� �ϳ��϶�  : G_INJECTOIN_MAIL_ADDR = "root@gabia.com"
											//	   �ڵ� ��2) �޴� �����ּҰ� �������� ��� :  G_INJECTOIN_MAIL_ADDR = "aaa@gabia.com,bbb@gabia.com"   <===  , �� �����ؼ� �ۼ��Ͻø� �˴ϴ�.
}

if ( trim($G_INJECTOIN_URL_CHANGE) == "" ){
	$G_INJECTOIN_URL_CHANGE = "Y" ;          //<-- �������ɺκ� : �⺻�� Y, Y - injectoin ���� ������ üũ�� ��� 
											//                   G_INJECTOIN_URL_NAME ������ ������ �̵�, N - URL �̵�����
											//    �ڵ� ��) G_INJECTOIN_URL_CHANGE = "N"
}

if ( trim($G_INJECTOIN_URL_NAME) == "" ){
	$G_INJECTOIN_URL_NAME  = COMPANY_URL	;  	        //<-- �������ɺκ� : �⺻�� �⺻������, G_INJECTOIN_URL_CHANGE ���� Y�̰� 
											//                  injectoin ���� ������ üũ�Ǵ� ��� �̵��ϴ� URL��
											// �ڵ� ��) G_INJECTOIN_URL_NAME = "http://www.gabia.com" <==  http://���� ��� �ۼ����ּž� �մϴ�.
}

if ( trim($G_INJECTOIN_URL_ALERT) == "" ){     
	$G_INJECTOIN_URL_ALERT = "��ȿ���� ���� ���ڰ� üũ�Ǿ� ������ �̵��մϴ�" ;            //<-- �������ɺκ� : �⺻�� "��ȿ���� ���� ���ڰ� üũ �Ǿ����ϴ�." 
	                                         //                   G_INJECTOIN_URL_NAME�� �̵��ϱ� �� ������ �޽���
											 //�ڵ� ��) G_INJECTOIN_URL_ALERT = "��ȿ���� ���� ���ڰ� üũ�Ǿ� ������ �̵��մϴ�."
}
/************** ���� ���� ���� ���� ���� ���� �� **************/


/****************** �Ʒ����ʹ� ������ �Ͻø� �ڵ尡 ����� ������ �ȵ� �� �ֽ��ϴ�. ***********************/

if ( $G_INJECTION_PATTERN_CHK == "" ) {
	$G_INJECTION_PATTERN_CHK = "Y";
}

If ( $G_INJECTION_PATTERN_CHK == "Y" ){


	// ���� üũ
	if( trim($G_INJECTOIN_MAIL_SEND) == "" ){
		$G_INJECTOIN_MAIL_SEND = "Y";
	}

	if( trim($G_INJECTOIN_URL_CHANGE) == "" ){
		$G_INJECTOIN_URL_CHANGE = "Y";
	}


	if( trim($G_INJECTOIN_URL_ALERT) == "" ){
		$G_INJECTOIN_URL_ALERT = "��ȿ���� ���� ���ڰ� üũ �Ǿ����ϴ�.";
	}


	if( trim($G_INJECTOIN_URL_NAME) == "" ){
		$G_INJECTOIN_URL_NAME = "http://".$HTTP_HOST;
	}
	
	//���� ����
	$G_INJECTION_PATTERN = "/delete[[:space:]]+from|drop[[:space:]]+database|drop[[:space:]]+table|drop[[:space:]]+column|drop[[:space:]]+procedure| create[[:space:]]+table|union[[:space:]]+all|update.+set.+=|insert[[:space:]]+into.+values|select.+from|bulk[[:space:]]+insert|or.+1[[:space:]]*=[[:space:]]1|alter[[:space:]]+table|into[[:space:]]+outfile|\/\*|\*\//";

	//�⺻ ���� ����
	$G_INJECTION_CHECK_VALUE = false;
	$G_INJECTION_CHECK_LIST  = "";
	$G_INJECTION_CHECK_ITEM  = "";
		
	//post�� ����
	foreach($_POST as $key => $post_value){
		if( preg_match($G_INJECTION_PATTERN, $post_value) ){
			$G_INJECTION_CHECK_LIST  =  $post_value;
			$G_INJECTION_CHECK_ITEM  = 'POST';
			$G_INJECTION_CHECK_VALUE = true;
			break;
		}			
		
	}
	//echo 'get �����մϴ�.';

	//get�� ����
	if( $G_INJECTION_CHECK_VALUE == False){
		foreach($_GET as $key => $get_value){
			if( preg_match($G_INJECTION_PATTERN, $get_value) ){
				$G_INJECTION_CHECK_LIST  =  $get_value;
				$G_INJECTION_CHECK_ITEM  = 'GET';
				$G_INJECTION_CHECK_VALUE = true;
				break;
			}			
		}
	}

	if( $G_INJECTION_CHECK_VALUE == False){
		$REQUEST_URI_ARRAY = explode("?",$_SERVER["REQUEST_URI"]);
		$req_value = $REQUEST_URI_ARRAY[1];
		if( preg_match($G_INJECTION_PATTERN,$req_value) ){
			$G_INJECTION_CHECK_LIST  =  $req_value;
			$G_INJECTION_CHECK_ITEM  = 'REQUEST_URI';
			$G_INJECTION_CHECK_VALUE = true;
			break;
		}	
	}

	
	//���Ϻ�����, ���� :  �����ּҰ� �ְ� �����ּ� ������ ���� Y�̰� injection ���Ͽ� üũ�Ǿ��� ��� 
	if ( $G_INJECTOIN_MAIL_ADDR != ""  &&   $G_INJECTOIN_MAIL_SEND == "Y" &&  $G_INJECTION_CHECK_VALUE == true ){
		
		//���� ������
		$POST_MESSAGE = print_r ($HTTP_POST_VARS, true);
		$GET_MESSAGE  = print_r ($HTTP_GET_VARS, true);

		$mail_to = $G_INJECTOIN_MAIL_ADDR;							//�޴¸����ּ�
		$mail_subject = "SQL INJECTION ���� ������($HTTP_HOST)";	//����
		$mail_body = 
						"<body>
						<table width=500 cellpadding=5 cellspacing=0 border=1 style='border-collapse:collapse;' bordercolor='#CBC4B1'>
						<tr bgcolor='#F2F0EE'><td colspan='2'><b>Exception ����</b></td></tr>
						<tr><td width=200 bgcolor='#F9F8F7'>ȣ��Ʈ(������)��</td><td>".$HTTP_HOST."</td></tr>
						<tr><td bgcolor='#F9F8F7'>ȣ��(üũ)�� ������</td><td>".$SCRIPT_FILENAME."</td></tr>
						<tr><td bgcolor='#F9F8F7'>refer(����) ������ </td><td>".$HTTP_REFERER."</td></tr>
						<tr><td bgcolor='#F9F8F7'>POST Parameter</td><td><pre>".$POST_MESSAGE."</pre></td></tr>
						<tr><td bgcolor='#F9F8F7'>GET Parameter</td><td><pre>".$GET_MESSAGE."</pre></td></tr>
						<tr><td bgcolor='#F9F8F7'>üũ�� ��</td><td>".$G_INJECTION_CHECK_LIST."</td></tr>
						<tr><td bgcolor='#F9F8F7'>üũ�� ����</td><td>".$G_INJECTION_PATTERN."</td></tr>
						<tr><td bgcolor='#F9F8F7'>üũ�� ����</td><td>".$G_INJECTION_CHECK_ITEM."</td></tr>
						</table>
						<body>";

		$mail_header = "From: root@$HTTP_HOST\r\n";				//������ �����ּ�
		$mail_header .= "Reply-to: root@$HTTP_HOST\r\n";
		$mail_header .= "Content-Type: text/html\r\n";

		mail($mail_to,$mail_subject,$mail_body,$mail_header);
	}

	// url �̵��ϱ�, ���� :  url���� �����ϰ� url�̵��ϴ°��� Y injection ���Ͽ� üũ�Ǿ��� ���
	if ( $G_INJECTOIN_URL_CHANGE != "" && $G_INJECTOIN_URL_CHANGE == "Y" && $G_INJECTION_CHECK_VALUE == true ){
		echo "<script language='javascript'>\n";
		echo "alert('$G_INJECTOIN_URL_ALERT')\n";
		echo "parent.location.href='$G_INJECTOIN_URL_NAME'\n";
		echo "</script>\n";
		exit;
	}

}//If ( $G_INJECTION_PATTERN_CHK == "Y" ){