/* Scripsts Slider Feliz7Play */

function pa_slider_principal() {
	var w = window.innerWidth;
	if (w <= 992) {
		var sliders = document.querySelectorAll(
			".pa-slider-principal .glide__slide"
		);
		sliders.forEach(function (element) {
			var url = element.getAttribute("data-img-cell");
			element.style.backgroundImage = "url(" + url + ")";
		});
	}

	// Glide slider principal
	var glide = new Glide(".pa-glide-principal", {
		type: "carousel",
		perView: 1,
		gap: 0,
		animationDuration: 0,
		autoplay: 5000,
	});

	glide.mount();
}
