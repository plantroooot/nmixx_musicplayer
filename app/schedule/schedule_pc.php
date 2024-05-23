<link href='/js/fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='/js/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='/js/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='/js/fullcalendar/packages/list/main.css' rel='stylesheet' />
<link href='/css/fullcalendar.css' rel='stylesheet' />
<script src='/js/fullcalendar/packages/core/main.js'></script>
<script src='/js/fullcalendar/packages/interaction/main.js'></script>
<script src='/js/fullcalendar/packages/daygrid/main.js'></script>
<script src='/js/fullcalendar/packages/timegrid/main.js'></script>
<script src='/js/fullcalendar/packages/list/main.js'></script>
<script src='/js/fullcalendar/packages/core/locales/ko.js'></script>

<script>

    // const url = window.location.href;
    let todayDate = new Date();

    // if(url.split('?')[1] && url.split('?')[1].indexOf('date=') !== -1){
    //     todayDate.setMonth(parseInt(url.split('?')[1].substring(5, 15).split('-')[1]) - 1);
    //     todayDate.toString();
    // }
    // =============================================================
    // 					  FULLCALENDAR(LIBRARY)
    // =============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'interaction'],
            locale: 'ko',
            dateClick: function (info) {
                console.log(info.dateStr);
            },
            eventClick : function (info){
                let def = info.event._def;
                let sinfo = def.extendedProps.sinfo;                
                console.log(sinfo.sche_url);
                
                if(sinfo.sche_url){
                    window.open(sinfo.sche_url);
                }


            },
            eventData: function(eventEl) {
                // console.log(eventEl);
            },
            header: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            columnFormat: {
                day: 'numeric'
            },
            defaultDate: todayDate,
            // =============================================================
            // 						스캐줄 등록(json형식)
            // =============================================================
            events: <?php echo $result; ?>,
            // =============================================================
            // =============================================================
            eventRender: function(info) {
                let def = info.event._def;
                let sinfo = def.extendedProps.sinfo;
                
                var startHour = info.event.start.getHours();
                var startMinute = info.event.start.getMinutes();
                var startSecond = info.event.start.getSeconds();
                if (startHour === 0 && startMinute === 0 && startSecond === 0 && sinfo.sche_type == 3) {
                    var timeElement = info.el.querySelector('.fc-time');
                    if (timeElement) {
                        timeElement.classList.add('fc-time-none');
                    }
                }
                
                for(let i = 1; i <= 5; i++){
                    if(sinfo.sche_type == i){
                        var timeElement = info.el.querySelector('.fc-content');
                        if (timeElement) {
                            timeElement.classList.add('fc-content-color-'+i);
                        }
                    }
                }
            }
        });
        calendar.render();
    });
</script>
<div id="sub" class="schedule">
    <div class="sub-wrap">
        <?php
            include_once $_SERVER['DOCUMENT_ROOT']."/include/subvisual.php";
        ?>
        <section class="section section1">
            <div class="sec-wrap">
                <div class="size">
                    <div class="calendarWrap">
                        <div class="right-labels">
                            <ul>
                                <?php
                                    for($k = 1; $k <= 5; $k++){
                                ?>                                
                                <li><span><?php echo getScheduleType($k); ?></span><?php echo getScheduleType($k); ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div id='calendar'></div>
                    </div>                    
                </div>
            </div>
        </section>
    </div>
</div>