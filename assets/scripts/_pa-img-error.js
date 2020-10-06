function pa_img_error() {
	var images = document.querySelectorAll("img");
	images.forEach(function (images) {
		images.onerror = function () {
			images.src =
				"http://remake.com/wp-content/themes/PA-Theme-Sedes/assets/imgs/erro.svg";
			return true;
		};
	});

	return true;
}
