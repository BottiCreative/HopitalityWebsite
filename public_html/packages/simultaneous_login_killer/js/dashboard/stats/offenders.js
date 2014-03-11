ccmSlkOpenDetailStatsDialog = function(uID) {
	var query_string = "uID="+uID;
	jQuery.fn.dialog.open({
		width: 870,
		height: 600,
		modal: true,
		href: dialog_url+"?"+query_string,
		title: "View Logout History"
	});
}