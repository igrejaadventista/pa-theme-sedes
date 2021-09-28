export function pa_share(event, url) {
	event.preventDefault();
	window.open(
		url,
		"_blank",
		"location=yes,height=1060,width=1144,scrollbars=yes,status=yes"
	);
}
