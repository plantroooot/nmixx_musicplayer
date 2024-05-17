<?php
include_once $_SERVER['DOCUMENT_ROOT']."/include/common.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/YoutubeViews.class.php";

$youtube_views = new YoutubeViews(999, 'youtube_views', $_REQUEST);
$result = $youtube_views->getViewsData(1);

include_once $_SERVER['DOCUMENT_ROOT']."/header.php";

/*$data = json_decode(
'[
{"index": 1, "title": "O.O", "views": 108885339}, 
{"index": 2, "title": "DICE", "views": 107334921},
{"index": 3, "title": "Funky Glitter Christmas", "views": 8164243},
{"index": 4, "title": "Young, Dumb, Stupid", "views": 58774894},
{"index": 5, "title": "Love Me Like This", "views": 81316884},
{"index": 6, "title": "Roller Coaster", "views": 32889000},
{"index": 7, "title": "Party O\\u2019Clock", "views": 68739629},
{"index": 8, "title": "So\\u00f1ar (Breaker)", "views": 37238737}
]', true);

for($k = 0; $k < count($data); $k++){
	$r = $youtube_views->insert($data[$k]);
}*/

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div id="sub" class="sub_chart" style="width: 100%; max-width: 800px;">
	<canvas id="myLineChart" width="400" height="200"></canvas>

	<div class="btn_area clear">
		<?for($k = 1; $k <= 8; $k++){?>
			<button class="chart_btn" onclick="getChartData(<?=$k?>);"><?=getMVTitle($k)?></button>
		<?}?>
	</div>
</div>

<script>
// 차트 script
let myLineChart;
let totalData = <?=$result?>;

let chartData = {
  labels: totalData[0],
  datasets: [{
    label: totalData[2],
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
	fill: true,
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 3,
    data: totalData[1],
  }]
};

// 차트 옵션 설정
let toptions = {
  responsive: true,
	 interaction: {
      intersect: false,
    },
  scales: {
    y: {
      display: true,
      beginAtZero: true
    }
  }
};

// Line Chart 생성
let ctx = document.getElementById('myLineChart').getContext('2d');

function setChart(){

	if (myLineChart) {
		myLineChart.destroy(); // 이전 차트 파괴
	}
	
	myLineChart = new Chart(ctx, {
	  type: 'line',
	  data: chartData,
	  options: toptions
	});

}

setChart();

// ------------------- //

/* 차트 데이터 불러오기 */

function getChartData(type){
	$.ajax({
		url : 'getChartData.php',
		type : 'POST',
		data : {
			type : type
		},
		dataType : 'json',
		success : function(res){
			console.log(res);
			chartData.labels = res[0];
			chartData.datasets[0].label = res[2];
			chartData.datasets[0].data = res[1];
			setChart();
			//console.log(chartData);
		},
		error : function(error){
			console.log(error);
			return false;
		}
	});
}



</script>


<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
?>