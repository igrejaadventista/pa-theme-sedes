/* Scripsts Slider Destaques */

function pa_slider_destaques() {
	var select = ".pa-glide-destaques";

	var node = document.querySelector(select);
	if (document.body.contains(node)) {
		var glide = new Glide(select, {
			type: "carousel",
			perView: 1,
		});

		glide.mount();
	}
}

/* Scripsts Slider Destaques Departamentos */
function pa_slider_destaque_deptos() {
	var select = ".pa-destaque-deptos-sliders";

	var node = document.querySelector(select);
	if (document.body.contains(node)) {
		var glide = new Glide(select, {
			type: "carousel",
			perView: 1,
		});

		glide.mount();
	}
}
