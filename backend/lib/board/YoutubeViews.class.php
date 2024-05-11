<?
/*
*/
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db/DBConnection.class.php";
class YoutubeViews {
	
	// �˻� �Ķ���� (�ʱ� ���߽� �˻����� �����ʿ�)
	var $param = array (
			"stype",
			"sval",
			"sdateType",
			"sstartdate",
			"senddate",
			"sstate"
	);
	
	var $tableName;			// ���̺��
	var $pageRows;			// ������ �ο��
	var $startPageNo=0;		// limit ����������
	public $reqPageNo=1;	// ��û������
	var $conn;
	
	// ������
	function __construct($pageRows=0, $tableName='', $request='') {
		$this->pageRows = $pageRows;
		$this->tableName = $tableName;
	}
	
	// sql WHERE�� ����
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
		// ����Ʈ�ڽ� ���� �ּ� Ǯ�� ���.
		/*
		if (isset($p['sstate']) && $p['sstate'] != 'all') {
			$whereSql .= " AND C_state = ".$p['sstate'];
		}
		*/
		return $whereSql;
	}
	
	
	// ��ü�ο��, ������ī��Ʈ
	/*function getRankCount($param = "", $type=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$whereSql = $this->getWhereSql($param);	// where��

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
	}*/
	
	// ���
	function getViewsData($type=0) {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		$whereSql = $this->getWhereSql($param);	// where��
		
		$sql = "
			SELECT *
			FROM ".$this->tableName."
			WHERE ytvw_type = ".$type."
			AND ytvw_registdate BETWEEN '2023-12-22 00:00:00' AND '2023-12-22 23:59:59';
		";

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		$i = 0;
		$totalData = array();
		$labels = array();
		$data = array();

		while($row=mysqli_fetch_assoc($result)){
			$title = $row['ytvw_title'];
			$labels[$i] = $row['ytvw_registdate'];
			$data[$i] = $row['ytvw_views'];
			$i++;
		}

		$totalData[0] = $labels;
		$totalData[1] = $data;
		$totalData[2] = $title;
		
		return json_encode($totalData, JSON_UNESCAPED_UNICODE);
	}

	// ������ ���
	function insert($req="") {
		$dbconn = new DBConnection();
		$conn = $dbconn->getConnection();
		
		$sql = "
			INSERT INTO ".$this->tableName." (
				ytvw_title,
				ytvw_type,
				ytvw_views,
				ytvw_registdate,
				ytvw_delyn
			) VALUES (
				'".$req['title']."',
				'".$req['index']."',
				'".$req['views']."',	
				'2023-12-22 23:00:00',
				0			
			)
		";
		
		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);
		
		return $result;
	}
	
}
?>