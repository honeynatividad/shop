$(".bt-heading").click(function(){
	$(this).toggleClass('openNav');
	$(this).next('.bt-accordion').toggleClass('openNav');
});
function showCaption(caption_main_row){
	$('.caption-detail').css("display",'none');
	$('.delete-caption').remove();
	$('#caption_detail_'+caption_main_row).css("display",'block');
	var htmlbt = ' <a id="bt_delete'+caption_main_row+'" class="delete-caption btn btn-danger" style="background:red;" onclick="deleteCaption('+caption_main_row+');" >Delete Caption</a>';
	$('.bt-button p').append(htmlbt);
	
}

function changeClass(caption_row,value){
	$('#caption_'+caption_row).removeClass();
	$('#caption_'+caption_row).addClass('caption tp-caption '+value+' ui-widget');
}
function changeDatay(caption_row,value){
	$('#caption_'+caption_row).css('top', value+"px");
}
function changeDatax(caption_row,value){
	$('#caption_'+caption_row).css('left', value+"px");
}
function changeTextCaption(caption_row,value){
    document.getElementById("caption_"+caption_row).innerHTML = value;
}