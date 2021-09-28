/* Scripsts Slider Principal */
import Glide from '@glidejs/glide';

export function pa_slider_principal() {
	var select = ".pa-glide-principal";

	var node = document.querySelector(select);
	if (document.body.contains(node)) {
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
		var glide = new Glide(select, {
			type: "carousel",
			perView: 1,
			gap: 0,
			animationDuration: 0,
			// autoplay: 5000,
		});

		glide.mount();
	}
}
