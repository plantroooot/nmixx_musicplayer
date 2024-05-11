<?

include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db/DBConnection.class.php";

class Board {

	// 검색 파라미터 (초기 개발시 검색조건 세팅필요)
	var $param = array (
		"pageRows",
		"stype",
		"sval",
		"sdateType",
		"sstartdate",
		"senddate"
	);

	var $tableName;			// 테이블명
	var $pageRows;			// 페이지 로우수
	var $startPageNo=0;		// limit 시작페이지
	public $reqPageNo=1;	// 요청페이지
	var $conn;
	var $bname;


	// 생성자
	function __construct($pageRows=0, $tableName='', $request='', $bname='') {
		$this->pageRows = $pageRows;
		$this->tableName = $tableName;
		$this->reqPageNo = !isset($request['reqPageNo']) ? 1 : $request['reqPageNo'];	// 요청페이지값 없을시 1로 세팅
		if ($this->reqPageNo > 0) {
			$this->startPageNo = ($this->reqPageNo-1) * $this->pageRows;
		}
		$this->bname = $bname;
	}

	// 검색 파라미터 queryString 생성
	function getQueryString($page="", $no=0, $request='', $bname=''): string
    {
		// URL 파라미터에 게시판 코드가 없을경우 생성자의 4번째 파라미터를 받아옴.
		$request['bname'] = $request['bname'] ?? $this->bname;

		$str = '';
		if(count($request) > 0){
			for ($i=0; $i<count($this->param); $i++) {
				if (isset($request[$this->param[$i]] )) {
					$str .= $this->param[$i]."=".$request[$this->param[$i]]."&";
				}
			}
		}

		if ($no > 0) $str .= "no=".$no;			// no값이 있을 경우에만 파라미터 세팅 (페이지 이동시 no필요 없음)
		
		$return = '';
		if($bname == ''){
			if ($str) {
				$return = $page.'?bname='.$request['bname'].'&'.$str;
			} else {
				$return = $page.'?bname='.$request['bname'].'&';
			}
		}else{
			if ($str) {
				$return = '/board/'.$page.'?bname='.$request['bname'].'&'.$str;
			} else {
				$return = '/board/'.$page.'?bname='.$request['bname'].'&';
			}
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

		// URL 파라미터에 게시판 코드가 없을경우 생성자의 4번째 파라미터를 받아옴.
		$p['bname'] = isset($p['bname']) ? $p['bname'] : $this->bname;
		
		$whereSql = "WHERE 1=1 AND B_code = '{$p['bname']}' AND B_delyn = 0";

		if (isset($p['sval'])) {
			if(isset($p['stype'])){
				if ($p['stype'] == 'all') {
					$whereSql .= " AND ( (B_name LIKE '%".$p['sval']."%' ) or (B_title LIKE '%".$p['sval']."%' ) or (B_contents LIKE '%".$p['sval']."%') ) ";
				} else {
					$whereSql .= " AND ( B_".$p['stype']." LIKE '%".$p['sval']."%' )";
				}
			}
		}
		if (isset($p['sstartdate'])) {
			if ($p['senddate'] != '') {
				$whereSql .= " AND (B_crdt BETWEEN '".$p['sstartdate']." 00:00:00' AND '".$p['senddate']." 23:59:59') ";
			}
		}
		if (isset($p['scategory_fk']) && $p['scategory_fk'] !='') {
			$whereSql .= " AND B_categoryfk = '".$p['scategory_fk']."'";
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
		$sql = "SELECT COUNT(*) AS cnt FROM board ".$whereSql;
		
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
	function getList($req) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection(); //DB CONNECT
		$param = escape_string($req);	
		$whereSql = $this->getWhereSql($param);	// where절
		$joinSql = '';
		
		// URL 파라미터에 게시판 코드가 없을경우 생성자의 4번째 파라미터를 받아옴.
		$req['bname'] = $req['bname'] ?? $this->bname;

		$sql = "
			SELECT *, 
				(SELECT COUNT(*) FROM comment WHERE B_code = '{$req['bname']}' AND parent_fk = ".$this->tableName.".B_idx) AS comment_count,
				(SELECT C_categoryname FROM board_category WHERE C_idx = board.B_categoryfk AND C_delyn = 0) AS c_name
				FROM board".$joinSql."
				".$whereSql."
				ORDER BY B_top DESC, B_crdt DESC LIMIT ".$this->startPageNo.", ".$this->pageRows." ";
		// echo $sql;
		$result = mysqli_query($conn, $sql);

		mysqli_close($conn);

		return $result;
	}

	// 게시판 설정값
	function getSetting($req){
		$dbconn = new DBConnection(); 
		$conn = $dbconn->getConnection();

		$req = escape_string($req);

		$sql = "SELECT * FROM board_setup WHERE P_code = '{$req['bname']}'";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		$data = mysqli_fetch_assoc($result);
		
		return $data;

	}

	// 관리자 등록
	function insert($req="") {
		$dbconn = new DBConnection(); 
		$conn = $dbconn->getConnection();
		
		$req = escape_string($req);
		//$gno = $this->getMaxGno();
		
		$sql = "
			INSERT INTO board
			(B_code, B_name, B_title, B_contents, B_delyn, B_crdt, ";

		if (isset($req['linkinfo'])) {
			$sql .= "B_links, ";
		}
		if (isset($req['fileinfo'])) {
			$sql .= "B_files, ";
		}
		if (isset($req['imageinfo'])) {
			$sql .= "B_imageinfo, ";
		}
		if (isset($req['category'])) {
			$sql .= "B_categoryfk, ";
		}

		$sql .= "B_top)
			VALUES (
			'{$req['bname']}',
			'{$req['name']}',
			'{$req['title']}',
			'{$req['contents']}',
			'0', ";

		if (!$req['registdate'] == "") { 
			$sql .= "'{$req['registdate']}', ";
		} else {
			$sql .= "CURRENT_TIMESTAMP(), ";
		}
		if (isset($req['linkinfo'])) {
			$sql .= "'$req[linkinfo]', ";
		}
		if (isset($req['fileinfo'])) {
			$sql .= "'$req[fileinfo]', ";
		}
		if (isset($req['imageinfo'])) {
			$sql .= "'$req[imageinfo]', ";
		}
		if (isset($req['category'])) {
			$sql .= "'$req[category]', ";
		}
		
		if (isset($req['top'])) {
			$sql .= $req['top'].")";
		}else{
			$sql .= "'0' )";
		}

		$result = mysqli_query($conn, $sql);


		// extra_table 존재할 경우

		// $sql = "
		// 	INSERT INTO extratable
		// 	(B_idx, B_str)
		// 	VALUES(
		// 		LAST_INSERT_ID(), '{$req['contents']}'
		// 	)
		// ";

		// $result = mysqli_query($conn, $sql);

		return $result;
		
	}

	// 수정
	function update($req="") {

		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		
		$sql = "
			UPDATE board SET 
				B_name='".$req['name']."', B_title='".$req['title']."', B_contents='".$req['contents']."',
        	";
				
		if (isset($req['fileinfo'])) {
			$sql .= "B_files='".$req['fileinfo']."',";
		}

		if (isset($req['linkinfo'])) {
			$sql .= "B_links='".$req['linkinfo']."',";
		}

		if (isset($req['imageinfo'])){
			$sql .= "B_imageinfo='".$req['imageinfo']."',";
		}

		if (isset($req['category'])) {
			$sql .= "B_categoryfk='".$req['category']."',";
		}

		if (isset($req['readno'])) {
			$readno = isset($req['readno']) ? $req['readno'] : "0";
			$sql .= "readno=".$readno.", ";
		}
		if (isset($req['registdate'])) { 
			$sql .= "B_updt='".$req['registdate']."', ";
		}

		$top = isset($req['top']) ? $req['top'] : "0";
		$sql .= " B_top='".$top."' WHERE B_idx = ".$req['no'];


		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
	}

	// 삭제
	function delete($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "UPDATE board SET B_delyn = 1 WHERE B_idx = ".$no;

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $result;
	}


	// 목록
	function getData($no=0, $userCon) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();


		$sql = "
			SELECT *,
			(SELECT C_categoryname FROM board_category WHERE C_idx = board.B_categoryfk) AS c_name
			FROM board
			WHERE B_idx = ".$no;

		// 조회수 증가
		if ($userCon) {
			mysqli_query($conn, "UPDATE board SET B_readno=B_readno+1 WHERE B_idx=".$no);
		}
		
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
				filename, moviename, imagename
			FROM ".$this->tableName."
			WHERE no = ".$no;
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		return $result;
	}

	function getCategory($req='') {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "SELECT * FROM board_category WHERE B_code = '{$req['bname']}' AND C_delyn = 0 ORDER BY C_ordinumber ASC";

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
				SELECT @rownum:=@rownum+1 AS rownum, B_idx, B_title FROM board, (SELECT @rownum:=0) AS r
				".$whereSql."
				ORDER BY B_top DESC, B_crdt DESC
			) AS r2
			WHERE r2.B_idx = ".$req['no'];
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		$row=mysqli_fetch_array($result);
		$rownum = $row['rownum'];

		return $rownum;
	}

	// 다음글 가져오기
	function getPrevRowNum($req='', $rownum=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);
		$whereSql = $this->getWhereSql($req);	// where절

		$sql = "
			SELECT
				ifnull(rownum,0), ifnull(B_idx,0) AS prev_no, B_title AS prev_title, B_crdt AS prev_registdate
			FROM (
				SELECT @rownum:=@rownum+1 AS rownum, B_idx, B_title, B_crdt from board, (SELECT @rownum:=0) AS r
				".$whereSql."
				ORDER BY B_top DESC, B_crdt DESC
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
				ifnull(rownum,0), ifnull(B_idx,0) AS next_no, B_title AS next_title, B_crdt AS next_registdate
			FROM (
				SELECT @rownum:=@rownum+1 AS rownum, B_idx, B_title, B_crdt from board, (SELECT @rownum:=0) AS r
				".$whereSql."
				ORDER BY B_top DESC, B_crdt DESC
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

		$sql = "UPDATE ".$this->tableName." SET B_readno = B_readno+1 WHERE B_idx = $no";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		return $result;
	}

	// 메인목록 조회
	function getMainList($number) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$whereSql = $this->getWhereSql($param);	// where절

		$sql = "
			SELECT *
			FROM ".$this->tableName."
			ORDER BY registdate DESC 
			LIMIT 0, ".$number." ";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		return $result;
	}
	
}


?>