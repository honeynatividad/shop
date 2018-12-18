$(document).ready(function() {
	function addStyle(i){
		$("#" + id_Color_List[i]).css('background', '#' + $("#" + id_Color_List[i]).val());
	}
	for(var i = 0 ; i < id_Color_List.length; i++ ){
			addStyle(i);
	};
});

(function($){
	function changeColorPicker(i){
		$('#' + id_Color_List[i]).ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).css({backgroundColor:"#" + hex});
				$(el).ColorPickerHide();
			},
			onChange: function (hsb, hex, rgb) {
				
				$("#" + id_Color_List[i]).css('background', '#' + hex);
				$("#" + id_Color_List[i]).val(hex);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
			
		});
	};	
	var initLayout = function() {
		for(var i = 0 ; i < id_Color_List.length; i++ ){
			changeColorPicker(i);
		};
	};	
	EYE.register(initLayout, 'init');
})(jQuery)























