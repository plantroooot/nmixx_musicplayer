<?
/*
*/
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db/DBConnection.class.php";
class Rank {
	
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
	}
	
	// sql WHERE절 생성
	function getWhereSql($p) {
		$whereSql = " WHERE 1=1 AND rk_delyn = 0";
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
	function getRankCount($param = "", $type=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$whereSql = $this->getWhereSql($param);	// where절

		$sql = "
			SELECT COUNT(*) AS cnt
			FROM ".$this->tableName."
			".$whereSql."
			AND rk_type = ".$type."
			ORDER BY rk_registdate DESC 
			LIMIT 1
		";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		$row=mysqli_fetch_array($result);
		$totalCount = $row['cnt'];

		return $totalCount;
	}
	
	// 목록
	function getRankList($param='', $type=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$whereSql = $this->getWhereSql($param);	// where절
		
		$sql = "
			SELECT *
			FROM ".$this->tableName."
			".$whereSql."
			AND rk_type = ".$type."
			ORDER BY rk_registdate DESC 
			LIMIT 1
		";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		$row=mysqli_fetch_assoc($result);
		$data = json_decode($row['rk_content'], true);
		
		return $data;
	}
	
}
?>