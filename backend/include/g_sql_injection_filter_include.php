<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
/*
*SQL INJECTION  üũ ���� include�ϴ� ����, üũ ���ϸ� : g_sql_injection_filter.php
*(��)����� �ۼ�
*/

/*************** ���� ����  (��)����� *************** 
1. �Ʒ��� ���ں������� Ư������������ g_sql_injection_filter.php ���Ͼ��� ���ں����� �ٸ� ������ ó���ϰ� ���� ��� ���˴ϴ�. 
   ���� ���ų� ������ �������� g_sql_injection_filter.php ���� �������� ���� ó���� �˴ϴ�.

2. g_sql_injection_filter.php �� include�ϴ� �κ����� ��ġ�ϸ� �˴ϴ�.

3. �Ʒ��� ���ں������� g_sql_injection_filter.php �ȿ� �ִ� �������� �켱�մϴ�.

4. �⺻���̶�� ���� �״�� �νø� �⺻����� ���α׷��� ������ �ȴٴ� ���Դϴ�.

5. �Ʒ� �������� "" ���� ���� �Ʒ� ������ �����Ͻþ� �����Ͻø� �˴ϴ�. �ڵ� ��) $G_INJECTION_PATTERN_CHK = "N" 

6. �Ʒ� ���� ������ �ڵ� ��)�� �ٸ� �������� ������ ���α׷��󿡼� ������ �߻��� �� �ֽ��ϴ�.
*******************************************************/

/************* ���� ���� ���� ���� ���� ���� *************/
// �����Ͻ� �������� ""�� ���� �����Ͻø� �˴ϴ�.

$G_INJECTION_PATTERN_CHK = "Y";    //�⺻�� Y, Y - injection ���� ������ üũ��,    N - ���α׷��� ������� 

$G_INJECTOIN_MAIL_SEND   = "Y";    //�⺻�� Y, Y - injectoin ���� ������ üũ�� ��� ���Ϻ���,  N - ���� �� ���� 

$G_INJECTOIN_MAIL_ADDR   = "";    //$G_INJECTOIN_MAIL_SEND ���� Y�� ��� $G_INJECTOIN_MAIL_ADDR ������ SEQ INJECTION ������ ������
								 //�ڵ� ��1) �޴� �����ּҰ� �ϳ��϶�  : $G_INJECTOIN_MAIL_ADDR = "root@gabia.com"
							     //�ڵ� ��2) �޴� �����ּҰ� �������� ��� :  $G_INJECTOIN_MAIL_ADDR = "aaa@gabia.com,bbb@gabia.com"   <===              , �� �����ؼ� �ۼ��Ͻø� �˴ϴ�.

$G_INJECTOIN_URL_CHANGE  = "Y";   //�⺻�� Y, Y - injectoin ���� ������ üũ�� ��� $G_INJECTOIN_URL_NAME ������ ������ �̵�,  N - URL�̵�����

$G_INJECTOIN_URL_NAME    = COMPANY_URL;   //�⺻�� �⺻������, $G_INJECTOIN_URL_CHANGE ���� Y�̰� injectoin ���� ������ üũ�Ǵ� ��� �̵��ϴ� URL��
								 //�ڵ� ��) http://www.gabia.com <==  http://���� ��� �ۼ����ּž� �մϴ�.

$G_INJECTOIN_URL_ALERT   = "��ȿ���� ���� ���ڰ� üũ �Ǿ����ϴ�.";   //'�⺻�� "��ȿ���� ���� ���ڰ� üũ �Ǿ����ϴ�.", $G_INJECTOIN_URL_NAME�� �̵��ϱ� �� ������ �޽���

/************** ���� ���� ���� ���� ���� ���� �� **************/



//�Ʒ��� ������ include �ϴ� �κ��Դϴ�
include($_SERVER[DOCUMENT_ROOT]."/include/g_sql_injection_filter.php");  //()���� ���� ��θ� �����Ͻø� �˴ϴ�.

//���⼭ ���ʹ� php �ҽ��Դϴ�.
//echo  "������ʹ� php �ҽ��Դϴ�.";
?>