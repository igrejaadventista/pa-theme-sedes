/* Scripsts Slider Destaques */
import Glide from '@glidejs/glide';

export function pa_slider_destaques() {
	var nodes = document.querySelectorAll('.pa-glide-destaques');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
		var glide = new Glide(node, {
			type: "carousel",
			perView: 1,
		});

		glide.mount();
	});
}

/* Scripsts Slider Destaques Departamentos */
export function pa_slider_destaque_deptos() {
	var nodes = document.querySelectorAll('.pa-destaque-deptos-sliders');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {

    var autoPlay    = node.dataset.autoplay;
    
		var glide = new Glide(node, {
			type: "carousel",
			perView: 1,
      autoplay: autoPlay,
		});

		glide.mount();
	});
}

/* Scripsts Slider Destaques Departamentos */
export function pa_slider_magazines() {
	var nodes = document.querySelectorAll('.pa-slider-magazines');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
		var glide = new Glide(node, {
			type: "carousel",
			perView: 1,
		});

		glide.mount();
	});
}
