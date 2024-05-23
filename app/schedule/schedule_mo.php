<div id="sub" class="schedule">
    <div class="sub-wrap">
        <?php
            include_once $_SERVER['DOCUMENT_ROOT']."/include/subvisual.php";
        ?>
        <section class="section section1">
            <div class="sec-wrap">
                <div class="size">
                    <div class="calendarWrap">
                        <div id='calendar'></div>
                    </div>                    
                </div>
            </div>
        </section>
    </div>
</div>

<link rel="stylesheet" href="/css/fullcalendar_mo.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var infolist = <?php echo $result; ?>;
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone : 'UTC',
            initialView: 'dayGridMonth',
            titleFormat: function (date) {
                // YYYY년 MM월
                return `${date.date.year}. ${date.date.month + 1}`;
            },
            headerToolbar: {
                right: 'next',
                center: 'title',
                left: 'prev',
            },
            editable: true, // false로 변경 시 draggable 작동 x 
            dayMaxEventRows: 3, // 이벤트 표시 최대 행 수
            showNonCurrentDates: false, // 이전 달과 다음 달의 날짜를 표시하지 않음
            fixedWeekCount: false, // 각 월에 항상 6주 표시
            events : infolist,
            dateClick: function (info) {

                $('#schedulePopup h2').text('');
                $('#schedulePopup .list-wrap ul li').remove();

                // 팝업 날짜 제목
                var clickedDate1 = info.date;
                var month = (clickedDate1.getMonth() + 1).toString().padStart(2, '0');
                var day = clickedDate1.getDate().toString().padStart(2, '0');
                var formattedDateString = `${clickedDate1.getFullYear()}년 ${month}월 ${day}일`;

                var clickedDate2 = info.dateStr;
                var targetDayEvent = infolist.filter(function(item){
                    var itemDate = item.start.split(' ')[0];
                    return itemDate === clickedDate2;
                });

                
                if(targetDayEvent.length){
                    $('#schedulePopup h2').text(formattedDateString);
                    let tag = '';
                    let tag_a = '';

                    for(let i = 0; i < targetDayEvent.length; i++){
                        let timeArr = targetDayEvent[0].start.split(' ')[1].split(':');
                        let time = timeArr[0]+':'+timeArr[1];
                        time = time != '00:00' ? time : '';
                        let url = targetDayEvent[i].sinfo.sche_url;
                        if(url != '' && url != null){
                            tag_a = `<a href="${url}" target="_blank">바로가기</a>`
                        }else{
                            tag_a = '';
                        }
                        tag += `                            
                            <li>
                                <div class="box">
                                    <h3>${targetDayEvent[i].title}</h3>
                                    <span>${time}</span>
                                    ${tag_a}
                                </div>
                            </li>
                        `;
                    }

                    $('#schedulePopup .list-wrap ul').html(tag);



                    openPopup('schedulePopup');
                }

            },
            eventDidMount: function (e) {
                var eventHarness = $('.fc-daygrid-event-harness');
                for(let i = 0; i < eventHarness.length; i++){
                    eventHarness.eq(i).parents('.fc-daygrid-day').find('.fc-daygrid-day-top').addClass('on');
                }
            },
        });

        calendar.render();
        
        var eventHarness = $('.fc-daygrid-event-harness');
        for(let i = 0; i < eventHarness.length; i++){
            eventHarness.eq(i).parents('.fc-daygrid-day').find('.fc-daygrid-day-top').addClass('on');
        }
    });
</script>
<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/include/popup/schedule_popup.php";
?>