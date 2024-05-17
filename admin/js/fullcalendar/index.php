<?
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Calendar.class.php";
$cal = new Calendar(9999, 'calendar', $_REQUEST);

$result = $cal->getList($_REQUEST);

while ($row=mysqli_fetch_assoc($result)){
    $output[] = array('title' => $row['title'],
        'url' => '#',
        'number' => $row['no'],
        'registdate' => $row['registdate'],
        'place' => $row['place'],
        'start' => $row['registdate']);
}

	$root = $_SERVER['DOCUMENT_ROOT'];
	$p = "support";
	$sp = 1;
	include_once $root."/header.php";
?>
<link href='./packages/core/main.css' rel='stylesheet' />
<link href='./packages/daygrid/main.css' rel='stylesheet' />
<script src='./packages/core/main.js'></script>
<script src='./packages/interaction/main.js'></script>
<script src='./packages/daygrid/main.js'></script>
<script src='./packages/core/locales/ko.js'></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

	////data_event  변수에..배열처리한 데이터.

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid', 'interaction'],
	  dateClick: function (info) {
		console.log(info.dateStr)
		var dateName = info.dateStr;
		// $('.fc-day-number').removeClass('on')
		// $('.fc-day-top[data-date='+dateName+']').find('.fc-day-number').addClass('on')
	  },
	  eventClick: function (info) {
          console.log(info.event._def.title);
          console.log(info.event._def.url);
          console.log(info.event._def.extendedProps.number);
          console.log(info.event._def.extendedProps.registdate);
          console.log(info.event._def.extendedProps.place);

          $('.car_title').html(info.event._def.title);
          $('.car_date').html(info.event._def.extendedProps.registdate);
          $('.car_place').html(info.event._def.extendedProps.place);
		  info.jsEvent.preventDefault();
		popupPop();
	  },
      header: {
        left: 'prev,next',
        center: 'title',
        right: ''
      },
	  columnFormat: {
		day: 'numeric'
	  },
	  scrollTime: false,
      defaultDate: new Date(),
      //navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events:
        <?php echo json_encode($output);?>
	  ,
	  locale: 'ko'
    });

    calendar.render();
	
  });
  
</script>
<div id="sub" class="intro support support_sch">
	<?include_once $root."/include/subvisual.php";?>
	<div class="sub_wrap">
		<div class="size">
			<div class="inner">
				<div class="tit_area">
					<h3>체육회 일정</h3>
					<p>달력의 내용을 클릭하시면 자세히 보실 수 있습니다.</p>
				</div>
				<div class="cont_area">
					<!-- <div class="calendar">
						<div class="cal_head">
							<a href="javascript:;" class="month_btn month_prev"></a>
							<p>2022.12</p>
							<a href="javascript:;" class="month_btn month_next"></a>
						</div>
						<div class="cal_body">
							<table>
								<caption>달력</caption>
								<colgroup>
									<col width="14.28%" />
									<col width="14.28%" />
									<col width="14.28%" />
									<col width="14.28%" />
									<col width="14.28%" />
									<col width="14.28%" />
									<col width="14.28%" />
								</colgroup>
								<thead>
									<tr>
										<th class="rd">일</th>
										<th>월</th>
										<th>화</th>
										<th>수</th>
										<th>목</th>
										<th>금</th>
										<th class="bl">토</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="rd vis"><a href="javascript:;">27</a></td>
										<td class="vis"><a href="javascript:;">28</a></td>
										<td class="vis"><a href="javascript:;">29</a></td>
										<td class="vis"><a href="javascript:;">30</a></td>
										<td><a href="javascript:;">1</a></td>
										<td><a href="javascript:;">2</a></td>
										<td class="bl"><a href="javascript:;">3</a></td>
									</tr>
									<tr>
										<td class="rd">
											<a href="javascript:;">4</a>
											<ul class="sch_list hide Notos">
												<li>
													<a href="javascript:popupPop();">제 12회 서구체육회장기자랑대회</a>
												</li>
												<li>
													<a href="javascript:popupPop();">제 10회 서구체육회장기자랑대회</a>
												</li>
											</ul>
										</td>
										<td>
											<a href="javascript:;">5</a>
											<ul class="sch_list hide Notos">
												<li>
													<a href="javascript:popupPop();">제 12회 서구체육회장기자랑대회</a>
												</li>
												<li>
													<a href="javascript:popupPop();">제 10회 서구체육회장기자랑대회</a>
												</li>
											</ul>
										</td>
										<td>
											<a href="javascript:;" class="on">6</a>
											<ul class="sch_list Notos">
												<li>
													<a href="javascript:popupPop();">제 12회 서구체육회장기자랑대회</a>
												</li>
												<li>
													<a href="javascript:popupPop();">제 10회 서구체육회장기자랑대회</a>
												</li>
											</ul>
										</td>
										<td><a href="javascript:;">7</a></td>
										<td><a href="javascript:;">8</a></td>
										<td><a href="javascript:;">9</a></td>
										<td class="bl"><a href="javascript:;">10</a></td>
									</tr>
									<tr>
										<td class="rd"><a href="javascript:;">11</a></td>
										<td><a href="javascript:;">12</a></td>
										<td><a href="javascript:;">13</a></td>
										<td><a href="javascript:;">14</a></td>
										<td><a href="javascript:;">15</a></td>
										<td><a href="javascript:;">16</a></td>
										<td class="bl"><a href="javascript:;">17</a></td>
									</tr>
									<tr>
										<td class="rd"><a href="javascript:;">18</a></td>
										<td><a href="javascript:;">19</a></td>
										<td><a href="javascript:;">20</a></td>
										<td><a href="javascript:;">21</a></td>
										<td><a href="javascript:;">22</a></td>
										<td><a href="javascript:;">23</a></td>
										<td class="bl"><a href="javascript:;">24</a></td>
									</tr>
									<tr>
										<td class="rd"><a href="javascript:;">25</a></td>
										<td><a href="javascript:;">26</a></td>
										<td><a href="javascript:;">27</a></td>
										<td><a href="javascript:;">28</a></td>
										<td><a href="javascript:;">29</a></td>
										<td><a href="javascript:;">30</a></td>
										<td class="bl"><a href="javascript:;">31</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div> -->
					<div id="calendar" class="full_cl"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="popup" class="popup support_sch hide">
	<div class="inner">
		<div class="tb">
			<div class="tbc">
				<div class="cont">
					<div class="tit_area">
						<h4>일정 정보</h4>
						<a href="javascript:popupHide();">닫기 버튼</a>
					</div>
					<div class="cont_area">
						<ul>
                            <li>
                                <div class="tit car_title"></div>
                                <div class="flt_wrap st1">
                                    <div class="flt_box Notos">일시</div>
                                    <div class="date car_date"></div>
                                </div>
                                <div class="flt_wrap st2">
                                    <div class="flt_box Notos">장소</div>
                                    <div class="loc car_place"></div>
                                </div>
                            </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="index.js"></script>
<?
	include_once $root."/footer.php";
?>