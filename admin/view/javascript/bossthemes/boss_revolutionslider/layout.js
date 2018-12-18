function colorEvent (colorItem)
{
	$("#" + colorItem + "").ColorPicker({
		color: "#0000ff",
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$("#" + colorItem).css("background", "#" + hex); //custom event change
			$("#" + colorItem).val("#" + hex);
			$("#bt_slide_prev").css('background-color', "#" + hex);
		}
	});
}