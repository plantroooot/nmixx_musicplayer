$(function(){
    // $('tbody a').on('click',function(){
    //     if($(this).hasClass('on')){
    
    //     }else{
    //         $('tbody tr td a').removeClass('on');
    //         $('tbody tr td .sch_list').addClass('hide');
    //         $(this).addClass('on');
    //         $(this).parent().find('.sch_list').removeClass('hide');
    //     }
    
    // });
    
})


function datePick(obj) {
    $('tbody tr td a').removeClass('on');
    $(obj).addClass('on')
}

function popupPop() {
	$('#popup').removeClass('hide')
}
function popupHide() {
	$('#popup').addClass('hide')
}