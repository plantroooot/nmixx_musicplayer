<?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/common.php"; ?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/siteProperty.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/codeUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/util/dateUtil.php";
include_once $_SERVER['DOCUMENT_ROOT']."/lib/board/Schedule.class.php";

include $_SERVER['DOCUMENT_ROOT']."/admin/include/loginCheck.php";
include "config.php";

/*
| ----------------------------------------------------------------------------------------
| 스케줄 리스트
| ----------------------------------------------------------------------------------------
*/
$schedule = new Schedule($pageRows, $tablename, $_REQUEST, $primary_key);
$rowPageCount = $schedule->getCount($_REQUEST);
$result = $schedule->getList($_REQUEST);

$rowPageNoDateCount = $schedule->getCount2($_REQUEST);
$result2 = $schedule->getList2($_REQUEST);
$colspan = 5;

include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/header.php";

?>
<style>
    .fc-day-grid-container{height: auto !important;}
</style>
<script>

function groupEdit() {	
	if ( $('input:checkbox[name="chk[]"]:checked').length > 0 ){

		if (confirm("선택한 항목을 수정하시겠습니까?")) {			
            $('input#cmd').val('EDIT');
			document.fboardlist.submit();
		}
        
	} else {
		alert("수정할 항목을 하나 이상 선택해 주세요.");
	}
}

function groupDelete() {	
	if ( $('input:checkbox[name="chk[]"]:checked').length > 0 ){

		if (confirm("선택한 항목을 삭제하시겠습니까?")) {			
            $('input#cmd').val('GROUPDELETE');
			document.fboardlist.submit();
		}
        
	} else {
		alert("삭제할 항목을 하나 이상 선택해 주세요.");
	}
}

</script>
<link href='/admin/js/fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='/admin/js/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='/admin/js/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='/admin/js/fullcalendar/packages/list/main.css' rel='stylesheet' />
<link href='/admin/css/fullcalendar.css' rel='stylesheet' />
<script src='/admin/js/fullcalendar/packages/core/main.js'></script>
<script src='/admin/js/fullcalendar/packages/interaction/main.js'></script>
<script src='/admin/js/fullcalendar/packages/daygrid/main.js'></script>
<script src='/admin/js/fullcalendar/packages/timegrid/main.js'></script>
<script src='/admin/js/fullcalendar/packages/list/main.js'></script>
<script src='/admin/js/fullcalendar/packages/core/locales/ko.js'></script>
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
                getScheduleWrite(info.dateStr+' 00:00:00');
            },
            eventClick : function (info){
                let def = info.event._def;
                let sinfo = def.extendedProps.sinfo;

                $('#sche_id').val(sinfo.sche_id);
                $('#sche_date').val(sinfo.sche_date);        // 일시
                $('#sche_target').val(sinfo.sche_target);    // 종류
                $('#sche_type').val(sinfo.sche_type);        // 내용선택
                $('#sche_contents').val(sinfo.sche_contents) // 내용

                //참여멤버
                $('.mem_list input[name="sche_nmem[]"]').prop('checked', false);
                let nmember_arr = sinfo.sche_nmem.split(',');
                for(let k = 0; k < nmember_arr.length; k++){
                    $('#sche_nmem'+nmember_arr[k]).prop('checked', true);
                }

                $('#delete_btn').css('display', 'inline-block');
                $('#cmd').val('EDIT');

                openPopup('popup_schedule');

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

    function fboardform_submit(e) {
        e.preventDefault();

        let frm = document.getElementById('fboardform');        
        let formData = new FormData(frm);

        
        $.ajax({
            url : 'ajax.php',
            type : 'POST',
            data : formData,
            enctype : 'multipart/form-data',
            processData : false,
            contentType : false,
            success : function(data){
                let r = data.trim();
                console.log(r);

                if(r == 'success'){
                    alert('저장되었습니다.');
                    location.reload();
                }else{
                    alert('요청처리중 장애가 발생하였습니다.');
                }
                
            },
            error : function(error){
                console.log(error);
            }
        });

        
	}

    $(document).on('change', '#sche_target', function(){
        let value = $(this).val();

        if(value == 2){
            $('input[name="sche_nmem[]"]').prop('checked', false);
            $('input[name="sche_nmem[]"]').prop('disabled', true);
        }else{
            $('input[name="sche_nmem[]"]').prop('disabled', false);
        }
        
    })

    $(document).on('change', '#sche_nmem1', function(){
        let flag = $(this).is(':checked');

        if(flag){
            $('.n_member').prop('checked', false);
            $('.n_member').prop('disabled', true);
        }else{
            $('.n_member').prop('disabled', false);
        }
        
    });

    $(document).on('change', '#sche_disabled', function(){
        let flag = $(this).is(':checked');

        if(flag){
            $('#sche_date').val('');
            $('#sche_date').prop('disabled', true);
        }else{
            $('#sche_date').prop('disabled', false);
        }
    });

    function getScheduleWrite(date=''){
        
        $('#sche_id').val('');
        $('#sche_date').val(date);    // 일시
        $('#sche_target').val(1);  // 종류
        $('#sche_type').val(1);    // 내용선택
        $('#sche_contents').val('') // 내용
        //참여멤버
        $('.mem_list input[name="sche_nmem[]"]').prop('checked', false);
        
        $('#delete_btn').css('display', 'none');

        $('#cmd').val('WRITE');
        openPopup('popup_schedule');
    }

    function goEdit(obj){

        $('#sche_id').val($(obj).siblings('.sche_id').val());
        $('#sche_target').val($(obj).siblings('.sche_target').val());
        $('#sche_type').val($(obj).siblings('.sche_type').val());
        $('#sche_contents').val($(obj).siblings('.sche_contents').val());

        //참여멤버
        $('.mem_list input[name="sche_nmem[]"]').prop('checked', false);
        let nmember_arr = $(obj).siblings('.sche_nmem').val().split(',');
        for(let k = 0; k < nmember_arr.length; k++){
            $('#sche_nmem'+nmember_arr[k]).prop('checked', true);
        }

        $('#delete_btn').css('display', 'inline-block');
        $('#cmd').val('EDIT');

        openPopup('popup_schedule');

    }

    function goDelete(){

        if(!confirm('삭제하시겠습니까?')){
            return false;
        }else{
            $('#cmd').val('DELETE');
    
            let frm = document.getElementById('fboardform');        
            let formData = new FormData(frm);
    
            
            $.ajax({
                url : 'ajax.php',
                type : 'POST',
                data : formData,
                enctype : 'multipart/form-data',
                processData : false,
                contentType : false,
                success : function(data){
                    let r = data.trim();
                    console.log(r);
    
                    if(r == 'success'){
                        alert('삭제되었습니다.');
                        location.reload();
                    }else{
                        alert('요청처리중 장애가 발생하였습니다.');
                    }
                    
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
        

    }

</script>
<div id="container" class="">
    <h1 id="container_title"><?php echo $pageTitle?></h1>
    <!-- 등록정보 -->
    <div class="container_wr">
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
        <div class="btn_fixed_top">
            <input type="button" name="act_button" value="등록" onclick="getScheduleWrite()" style="cursor: pointer;" class="btn_01 btn">
        </div>
        <div class="no_schedule_list">
            <div class="tbl_head01 tbl_wrap">
                <h2 class="h2_frm" style="margin-top: 0;">미정스케줄 목록</h2>
                <table>
                    <caption>미정스케줄 목록</caption>
                    <colgroup>
                        <col width="150px" />
                        <col width="150px" />
                        <col width="150px" />
                        <col width="*" />
                        <col width="115px" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">종류</th>
                            <th scope="col">참여멤버</th>
                            <th scope="col">분류</th>
                            <th scope="col">내용</th>
                            <th scope="col">관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            if($result){
                                foreach($result2 as $key => $row){
                        ?>      
                        <tr>
                            <td><?php echo getScheduleTarget($row['sche_target']); ?></td>
                            <td><?php echo getNmemberToText($row['sche_nmem'])?></td>
                            <td><?php echo getScheduleType($row['sche_type']); ?></td>
                            <td class="txt_l"><?php echo $row['sche_contents']?></td>
                            <td>
                                <div class="btnSet mt0">
                                    <a href="javascript:;" class="btn btn_03" onclick="goEdit(this);">수정</a>                                
                                    <input type="hidden" name="" value="<?php echo $row['sche_id']; ?>" class="sche_id" />
                                    <input type="hidden" name="" value="<?php echo $row['sche_target']; ?>" class="sche_target" />
                                    <input type="hidden" name="" value="<?php echo $row['sche_date']; ?>" class="sche_date" />
                                    <input type="hidden" name="" value="<?php echo $row['sche_type']; ?>" class="sche_type" />
                                    <input type="hidden" name="" value="<?php echo $row['sche_nmem']; ?>" class="sche_nmem" />
                                    <input type="hidden" name="" value="<?php echo $row['sche_contents']; ?>" class="sche_contents" />
                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                            if(!$result2){
                                echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div> 
        </div>

    </div>
    <!-- //등록정보 -->
</div>

<div id="popup_schedule" class="popup">
    <div class="pop_inner">
        <div class="popup_container">
            <div class="pop_pd">                
                <form name="fboardform" id="fboardform" action="/admin/post/process.php" onsubmit="return fboardform_submit(event)" method="post" enctype="multipart/form-data">
                    <div class="tbl_frm01 tbl_wrap">
                        <h2 class="h2_frm" style="margin-top: 0;">
                            스케줄 등록
                            <input type="button" value="X" class="fl_r close_btn" onclick="closePopup('popup_schedule');">
                        </h2>
                        <table>
                            <caption>스케줄 등록</caption>
                            <colgroup>
                                <col width="20%">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="sche_date">일시<strong class="sound_only">필수</strong></label></th>
                                    <td>
                                        <input type="text" name="sche_date" value="" id="sche_date" required class="required frm_input datetimepicker1" size="40" maxlength="120" readonly />
                                        <span class="check_box">
                                            <input type="checkbox" name="sche_disabled" value="1" id="sche_disabled">
                                            <label for="sche_disabled">미정</label>                                        
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="sche_target">종류<strong class="sound_only">필수</strong></label></th>
                                    <td colspan="3">                                    
                                        <select name="sche_target" id="sche_target" required class="required frm_input" style="width: 100%;">
                                            <?php
                                                for($k = 1; $k <= 3; $k++){
                                            ?>                                
                                            <option value="<?php echo $k; ?>"><?php echo getScheduleTarget($k); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">참여 멤버</th>
                                    <td class="sel_td">
                                        <div class="chk_list mem_list">
                                            <?php
                                                for($k = 1; $k <= 7; $k++){
                                            ?>                                
                                            <span class="check_box">
                                                <input type="checkbox" name="sche_nmem[]" value="<?php echo $k; ?>" id="sche_nmem<?php echo $k; ?>" <?php echo $k != 1 ? 'class="n_member"' : '';?>>
                                                <label for="sche_nmem<?php echo $k; ?>"><?php echo getNmember($k); ?></label>                                        
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="sche_contents">내용<strong class="sound_only">필수</strong></label></th>
                                    <td colspan="3">                                    
                                        <select name="sche_type" id="sche_type" class="required frm_input" style="width: 100%; margin-bottom: 5px;">
                                            <?php
                                                for($k = 1; $k <= 5; $k++){
                                            ?>                                
                                            <option value="<?php echo $k; ?>"><?php echo getScheduleType($k); ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" name="sche_contents" value="" id="sche_contents" required class="required frm_input full_input"  maxlength="120">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn_set txt_r">
                        <input type="button" name="act_button" id="delete_btn" value="삭제" class="btn_02 btn" style="display: none;" onclick="goDelete();">
                        <input type="submit" name="act_button" value="저장" class="btn_01 btn">
                    </div>
                    <input type="hidden" id="<?php echo $primary_key; ?>" name="<?php echo $primary_key; ?>" value="">
                    <input type="hidden" id="cmd" name="cmd" value="WRITE">
                </form>         
            </div>
        </div>
    </div>
</div>



<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/include/footer.php";
?>