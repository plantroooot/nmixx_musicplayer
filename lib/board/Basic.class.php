<?
/*
*/
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db/DBConnection.class.php";
class Basic {
	
	// 검색 파라미터 (초기 개발시 검색조건 세팅필요)
	var $param = array (
			"stype",
			"sval",
			"sdateType",
			"sstartdate",
			"senddate",
			"sstate"
	);
	
	var $tableName;			// 테이블명
	var $pageRows;			// 페이지 로우수
	var $startPageNo=0;		// limit 시작페이지
	public $reqPageNo=1;	// 요청페이지
	var $conn;
	
	// 생성자
	function __construct($pageRows=0, $tableName='', $request='') {
		$this->pageRows = $pageRows;
		$this->tableName = $tableName;
		$this->reqPageNo = !isset($request['reqPageNo']) ? 1 : $request['reqPageNo'];	// 요청페이지값 없을시 1로 세팅
		if ($this->reqPageNo > 0) {
			$this->startPageNo = ($this->reqPageNo-1) * $this->pageRows;
		}
	}
	
	// 검색 파라미터 queryString 생성
	function getQueryString($page="", $no=0, $request='') {
		$str = '';
		
		for ($i=0; $i<count($this->param); $i++) {
			if (isset($request[$this->param[$i]])) {
				$str .= $this->param[$i]."=".$request[$this->param[$i]]."&";
			}
		}
		
		if ($no > 0) $str .= "no=".$no;			// no값이 있을 경우에만 파라미터 세팅 (페이지 이동시 no필요 없음)
		
		$return = '';
		if ($str) {
			$return = $page.'?'.$str;
		} else {
			$return = $page;
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
		
		for ($i=0; $i<count($this->param); $i++) {
			if (isset($request[$this->param[$i]] )) {
				$str .= "<input type='hidden' name='".$this->param[$i]."' value='".$request[$this->param[$i]]."'/>\n";
			}
		}
		
		return $str;
	}
	
	// sql WHERE절 생성
	function getWhereSql($p) {
		$whereSql = " WHERE 1=1 AND BS_delyn = 0";
		if (isset($p['sval'])) {
			if(isset($p['stype'])){
				if ($p['stype'] == 'all') {
					$whereSql .= " AND ( (BS_title like '%".$p['sval']."%' ) or (BS_contents like '%".$p['sval']."%' ) or (BS_writer like '%".$p['sval']."%' ) ) ";
				} else{
					$whereSql .= " AND (BS_".$p['stype']." LIKE '%".$p['sval']."%')";
				}
			}
		}
		if (isset($p['sstartdate']) != '') {
			if ($p['senddate'] != '') {
				$whereSql .= " AND (BS_registdate BETWEEN '".$p['sstartdate']." 00:00:00' AND '".$p['senddate']." 23:59:59') ";
			}
		}
		// 셀렉트박스 사용시 주석 풀고 사용.
		/*
		if (isset($p['sstate']) && $p['sstate'] != 'all') {
			$whereSql .= " AND C_state = ".$p['sstate'];
		}
		*/
		return $whereSql;
	}
	
	
	// 전체로우수, 페이지카운트
	function getCount($param = "") {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$param = escape_string($param);
		$whereSql = $this->getWhereSql($param);	// where절
		$sql = "
			SELECT COUNT(*) AS cnt
			FROM ".$this->tableName."
		".$whereSql;
		
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
		$conn = $dbconn->getConnection();
		$param = escape_string($param);
		$whereSql = $this->getWhereSql($param);	// where절
		
		$sql = "
			SELECT *
			FROM ".$this->tableName."
			".$whereSql."
			ORDER BY BS_registdate DESC 
			LIMIT ".$this->startPageNo.", ".$this->pageRows." 
		";
		// echo $sql;
		// exit;
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
	}
	
	// 관리자 등록
	function insert($req="") {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		//$gno = $this->getMaxGno();
		$sql = "
			INSERT INTO ".$this->tableName." (
				BS_writer, BS_title, BS_contents,
		";
		/*if ($req['filename']) {
			$sql .= "filename, filename_org, filesize, ";
		}*/
		$sql .= " BS_registdate, BS_updatedate, BS_delyn
			) VALUES (
			'".$req['name']."',
			'".$req['title']."',
			'".$req['contents']."',
		";
		/*
		if ($req['filename']) {
			$sql .= "'$req[filename]', '$req[filename_org]', $req[filesize], ";
		}
		*/
		$sql .= "
			NOW(),
			NOW(),
			0
		)";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
	}
	
	// 수정
	function update($req="") {
		$req = getReqAddSlash($req);
		$req['contents'] = str_replace('\"\"', '', $req['contents']);
		$req['contents'] = str_replace('\"', '', $req['contents']);
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		
		// 기존 첨부파일 삭제
		/*if ($req['filename_chk'] == "1") {
			mysqli_query("UPDATE ".$this->tableName." SET filename='', filename_org='', filesize=0 WHERE no=".$req[no], $conn);
		}*/
		
		$sql = "
			UPDATE ".$this->tableName." SET
			BS_writer='".$req['name']."', 
			BS_title='".$req['title']."', 
			BS_contents='".$req['contents']."',
		"
		;
		/*if ($req['filename']) {
			$sql .= ", filename='$req[filename]', filename_org='$req[filename_org]', filesize=$req[filesize] ";
		}*/
	
		$sql .= "
			BS_updatedate = '".$req['registdate']."'
			WHERE BS_idx = ".$req['no'];
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $result;
	}
	
	// 삭제
	function delete($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "UPDATE ".$this->tableName." SET BS_delyn = 1 WHERE BS_idx = ".$no;
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $result;
	}
	
	// 목록
	function getData($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$sql = "
			SELECT *
			FROM ".$this->tableName."
			WHERE BS_idx = ".$no;
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		$data = mysqli_fetch_assoc($result);
		
		return $data;
	}
	
	// 파일명 가져오기
	function getFilenames($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "
			SELECT
				filename
			FROM ".$this->tableName."
			WHERE no = ".$no;
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
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
				ORDER BY top DESC, gno DESC, ono ASC
			) AS r2
			WHERE r2.no = ".$req['no'];
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
	}
	
	// 다음글 가져오기
	function getPrevRowNum($req='', $rownum=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		$whereSql = $this->getWhereSql($req);	// where절
		$sql = "
			SELECT
				ifnull(rownum,0), ifnull(no,0) AS prev_no, title AS prev_title, registdate AS prev_registdate
			FROM (
				SELECT @rownum:=@rownum+1 AS rownum, no, title, registdate from ".$this->tableName.", (SELECT @rownum:=0) AS r
				".$whereSql."
				ORDER BY top DESC, registdate DESC
			) AS r2
			WHERE r2.rownum = $rownum+1";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		$data = mysqli_fetch_assoc($result);
		return $data;
	}
	// 이전글 가져오기
	function getNextRowNum($req='', $rownum=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		$whereSql = $this->getWhereSql($req);	// where절
		$sql = "
			SELECT
				ifnull(rownum,0), ifnull(no,0) AS next_no, title AS next_title, registdate AS next_registdate
			FROM (
				SELECT @rownum:=@rownum+1 AS rownum, no, title, registdate from ".$this->tableName.", (SELECT @rownum:=0) AS r
				".$whereSql."
				ORDER BY top DESC, registdate DESC
			) AS r2
			WHERE r2.rownum = $rownum-1";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		$data = mysqli_fetch_assoc($result);
		return $data;
	}
	
	// 조회수 +1
	function updateReadno($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "UPDATE ".$this->tableName." SET readno = readno+1 WHERE no = $no";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $result;
	}
	
	// 목록
	function getMainList() {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "
			SELECT *
			FROM ".$this->tableName." AS lc
			WHERE answer is null OR answer = '<p>&nbsp;</p>' ";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
	}
	
}
?>