<?php
/*


*/

include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db/DBConnection.class.php";

class Post {

	// 검색 파라미터 (초기 개발시 검색조건 세팅필요)
	var $param = array (
		"pageRows",
		"stype",
		"sval",
		"sdateType",
		"sstartdate",
		"senddate",
		"bcode"
	);
	var $tableName;			// 테이블명
	var $pageRows;			// 페이지 로우수
	var $startPageNo=0;		// limit 시작페이지
	public $reqPageNo=1;	// 요청페이지
	var $conn;
	var $primary_key;

	// 생성자
	function __construct($pageRows=0, $tableName='', $request='', $primary_key='') {
		$this->pageRows = $pageRows;
		$this->tableName = $tableName;
		$this->reqPageNo = !isset($request['reqPageNo']) ? 1 : $request['reqPageNo'];	// 요청페이지값 없을시 1로 세팅
		$this->primary_key = $primary_key;
		if ($this->reqPageNo > 0) {
			$this->startPageNo = ($this->reqPageNo-1) * $this->pageRows;
		}
	}

	// 검색 파라미터 queryString 생성
	function getQueryString($page="", $no=0, $request='') {	
		$str = '';
		if(count($request) > 0){
			for ($i=0; $i<count($this->param); $i++) {
				if (Isset($request[$this->param[$i]] )) {
					$str .= $this->param[$i]."=".$request[$this->param[$i]]."&";
				}
			}
		}

		if ($no > 0) $str .= "no=".$no;			// no값이 있을 경우에만 파라미터 세팅 (페이지 이동시 no필요 없음)

		$return = '';
		if ($str) {
			$return = $page.'?'.$str;
		} else {
			$return = $page.'?';
		}

		
		
		return $return;
	}
	
	/**
	 * 검색조건에 맞는 hidden값 자동 생성
	 * @param string $request
	 * @return string
	 */
	function getQueryStringToHidden($request='') {
		$str = '';
		if(count($request) > 0){
		for ($i=0; $i<count($this->param); $i++) {
			if (Isset($request[$this->param[$i]] )) {
				$str .= "<input type='hidden' name='".$this->param[$i]."' value='".$request[$this->param[$i]]."'/>\n";
			}
		}
		}
	
		return $str;
	}

	// sql WHERE절 생성
	function getWhereSql($p) {
		$whereSql = " WHERE 1=1 AND post_delyn = 'N' AND brd_code = '".$p['bcode']."'";

		if (isset($p['sval'])) {
			if(isset($p['stype'])){
				if ($p['stype'] == 'all') {
					$whereSql .= " AND ( (name like '%".$p['sval']."%' ) or (title like '%".$p['sval']."%' ) or (contents like '%".$p['sval']."%') ) ";
				} else {
					$whereSql .= " AND (".$p['stype']." LIKE '%".$p['sval']."%' )";
				}
			}
		}
		if (isset($p['sstartdate'])) {
			if ($p['senddate'] != '') {
				$whereSql .= " AND (registdate BETWEEN '".$p['sstartdate']." 00:00:00' AND '".$p['senddate']." 23:59:59') ";
			}
		}


// 		if ($p['smain'] != '') {
// 			$whereSql .= " AND main = ".$p['smain'];
// 		}
		return $whereSql;
	}


	// 전체로우수, 페이지카운트
	function getCount($param = "") {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$param = escape_string($param);
		
		$whereSql = $this->getWhereSql($param);	// where절
		$sql = " SELECT COUNT(*) AS cnt FROM ".$this->tableName."".$whereSql;

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		$row=mysqli_fetch_array($result);
		$totalCount = $row['cnt'];
		$pageCount = getPageCount($this->pageRows, $totalCount);

		$data[0] = $totalCount;
		$data[1] = $pageCount;

		return $data;
	}

	// 목록
	function getList($param='') {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection(); //DB CONNECT
		$param = escape_string($param);	
		$whereSql = $this->getWhereSql($param);	// where절
		

		// $sql = "
		// 	SELECT *, 
		// 		(SELECT COUNT(*) FROM comment WHERE tablename = '".$this->tableName."' AND parent_fk = ".$this->tableName.".no) AS comment_count
		// 	FROM ".$this->tableName."
		// 	".$whereSql."
		// 	ORDER BY top DESC, registdate DESC LIMIT ".$this->startPageNo.", ".$this->pageRows." ";

		$sql = "
			SELECT *,			
			(SELECT CASE WHEN post_startdate > NOW() THEN '2' WHEN post_enddate < NOW() THEN '3' ELSE '1' END AS status) AS post_vote_status
			FROM ".$this->tableName."
			".$whereSql."
			ORDER BY post_top DESC, post_datetime DESC LIMIT ".$this->startPageNo.", ".$this->pageRows." ";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		
		$list = rstToArray($result);

		return $list;
	}

	// 관리자 등록
	function insert($req) {	
	
		$dbconn = new DBConnection(); 
		$conn = $dbconn->getConnection();
		$sql = insert_query($this->tableName, $req);
		
		$result = mysqli_query($conn, $sql);

		mysqli_close($conn);		
		return $result;

	}

	// 수정
	function update($no, $req="") {

		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$sql = update_query($this->tableName, $this->primary_key, $no, $req);
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		return $result;
	}

	// 삭제
	function delete($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$sql = "UPDATE ".$this->tableName." SET post_delyn = 'Y' WHERE post_id = ".$no;

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $result;
	}

	// 목록
	function getData($no=0, $userCon) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$sql = "
			SELECT *
			FROM ".$this->tableName."
			WHERE ".$this->primary_key." = ".$no;
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		$data = mysqli_fetch_assoc($result);

		return $data;
	}

	// 카테고리
	function getCategory($req='') {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$sql = "
			SELECT *,
			(SELECT COUNT(*) FROM board WHERE B_categoryfk = board_category.C_sqkey AND B_delyn = 0) AS b_cnt
			FROM board_category WHERE B_code = '{$req['P_code']}' AND C_delyn = 0 ORDER BY C_ordinumber ASC
		";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		return $result;
	}

	function getCategoryAllCount($req='') {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$sql = "
			SELECT COUNT(*) AS cnt FROM board_category WHERE B_code = '{$req['P_code']}'
		";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		$cnt = mysqli_fetch_assoc($result);

		return $cnt;
	}

	// rownum 구하기
	function getRowNum($req='') {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		$whereSql = $this->getWhereSql($req);	// where절

		$sql = "
			SELECT rownum FROM (
				SELECT @rownum:=@rownum+1 AS rownum, no, title FROM ".$this->tableName.", (SELECT @rownum:=0) AS r
				".$whereSql."
				ORDER BY top DESC, registdate DESC
			) AS r2
			WHERE r2.no = ".$req['no'];
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		$row=mysqli_fetch_array($result);
		$rownum = $row['rownum'];

		return $rownum;
	}	

	// 관리자 board메뉴 불러오기
	function getBoardGnb($param='') {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection(); //DB CONNECT
		$param = escape_string($param);	
		$whereSql = $this->getWhereSql($param);	// where절

		$sql = "
			SELECT brd_code, brd_title
			FROM ".$this->tableName." WHERE brd_delyn = 'N' ORDER BY brd_datetime ASC LIMIT ".$this->startPageNo.", ".$this->pageRows." 
		";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		$list = rstToArray($result);

		return $list;
	}
}


?>