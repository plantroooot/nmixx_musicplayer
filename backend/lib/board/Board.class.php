<?php
/*


*/

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
		$whereSql = " WHERE 1=1 AND brd_delyn = 'N'";


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
		$sql = " SELECT COUNT(*) AS cnt FROM board".$whereSql;

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
			(SELECT COUNT(*) FROM post WHERE brd_id = board.brd_id AND post_delyn = 'N') AS data_cnt
			FROM ".$this->tableName." WHERE brd_delyn = 'N' ORDER BY brd_datetime DESC LIMIT ".$this->startPageNo.", ".$this->pageRows." 
		";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		$list = rstToArray($result);

		return $list;
	}

	// 관리자 등록
	function insert($req="") {
		$dbconn = new DBConnection(); 
		$conn = $dbconn->getConnection();
		
		$req = escape_string($req);
		//$gno = $this->getMaxGno();

		$sql = "
			INSERT INTO board_setup 
			(P_type, P_type2, P_code, P_title, P_file, P_filecnt, P_category, P_link, P_linkcnt, P_newdate, P_crdt, P_updt, P_delyn)
			VALUES (
				'{$req['user_board']}',
				'{$req['manager_board']}',
				'{$req['board']}',
				'{$req['board_name']}',
				'{$req['setfile']}',
				'{$req['file_cnt']}',
				'{$req['setcategory']}',
				'{$req['setlink']}',
				'{$req['link_cnt']}',
				'{$req['newdate']}',
				CURRENT_TIMESTAMP(),
				CURRENT_TIMESTAMP(),				
				0
			);
		";

		$result = mysqli_query($conn, $sql);

		if($req['setcategory'] == "1"){

			for($i = 0; $i < (int)$req['category_cnt']; $i++){
				$sql = "
					INSERT INTO board_category
					(B_code, C_sqkey, C_categoryname, C_ordinumber, C_crdt)
					VALUES (
						'{$req['board']}',
						'{$req['ct_num'.strval($i+1)]}',
						'{$req['ct_name'.strval($i+1)]}',
						'{$req['ct_ordinumber'.strval($i+1)]}',
						CURRENT_TIMESTAMP()
					);
				";
				mysqli_query($conn, $sql);
			}
		}
		
		mysqli_close($conn);
		
		return $result;

	}

	// 수정
	function update($req="") {

		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$req = escape_string($req);

		$sql = "
			UPDATE board_setup SET
			
			P_type = '{$req['user_board']}',
			P_type2 = '{$req['manager_board']}',
			P_code = '{$req['board']}',
			P_title = '{$req['board_name']}', 
			P_file = '{$req['setfile']}', 
			P_filecnt = '{$req['file_cnt']}', 
			P_category = '{$req['setcategory']}', 
			P_link = '{$req['setlink']}', 
			P_linkcnt = '{$req['link_cnt']}', 
			P_newdate = '{$req['newdate']}', 
			P_updt = CURRENT_TIMESTAMP()

			WHERE P_idx = {$req['no']}
		";

		$result = mysqli_query($conn, $sql);

		// 게시판 코드 변경
		if($req['old_code'] != $req['board']){
			$sql = "
				UPDATE board SET 
				B_code = '{$req['board']}'
				WHERE B_code = '{$req['old_code']}'
			";
		 	mysqli_query($conn, $sql);
			
	
			$sql = "
				UPDATE board_category SET 
				B_code = '{$req['board']}'
				WHERE B_code = '{$req['old_code']}'
			";
			mysqli_query($conn, $sql);
		}


		// 카테고리 수정 / 추가 / 삭제		
		if($req['setcategory'] == "1"){

			for($i = 0; $i < (int)$req['category_old_cnt']; $i++){
				$sql = "
					UPDATE board_category SET
				";
				
				if(isset($req['ct_name'.strval($i+1)])){
					$sql .= "C_categoryname = '{$req['ct_name'.strval($i+1)]}',";
				}

				if(isset($req['ct_ordinumber'.strval($i+1)])){
					$sql .= "C_ordinumber = '{$req['ct_ordinumber'.strval($i+1)]}',";
				}

				$sql .= "
					C_delyn = '{$req['ct_del'.strval($i+1)]}'
					WHERE C_idx = {$req['C_no'.strval($i+1)]}
				";

				$result = mysqli_query($conn, $sql);
			}
		
			
			if($req['category_new_cnt'] > 0){
				for($i = 0; $i < (int)$req['category_new_cnt']; $i++){
					$sql = "
						INSERT INTO board_category
						(B_code, C_sqkey, C_categoryname, C_ordinumber, C_crdt)
						VALUES (
							'{$req['board']}',
							'{$req['ct_num'.strval($i+$req['category_old_cnt']+1)]}',
							'{$req['ct_name'.strval($i+$req['category_old_cnt']+1)]}',
							'{$req['ct_ordinumber'.strval($i+$req['category_old_cnt']+1)]}',
							CURRENT_TIMESTAMP()
						);
					";
					$result = mysqli_query($conn, $sql);
				}
			}

		}
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		return $result;
	}

	// 삭제
	function delete($no=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();

		$sql = "UPDATE board_setup SET P_delyn = 1 WHERE P_idx = ".$no;

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
			WHERE brd_id = ".$no;
		
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
}


?>