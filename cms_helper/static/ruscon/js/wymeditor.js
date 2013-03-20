$(document).ready(function() {
	$("[id^=id_content_]").wymeditor({
		skin : "django",
		lang : "en",
		stylesheet : "/static/cms/css/wymeditor.css",
		updateSelector : "input:submit",
		updateEvent : "click",
		postInit : function(wym) {
			wym.hovertools();
		}
	});
}); 