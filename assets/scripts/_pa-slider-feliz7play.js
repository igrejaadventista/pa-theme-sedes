/* Scripsts Slider Feliz7Play */
import Glide from '@glidejs/glide';

export function pa_slider_feliz7play() {
	var nodes = document.querySelectorAll('.pa-glide-feliz7play');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
		var glide = new Glide(node, {
			type: "carousel",
			startAt: 0,
			perView: 3,
			gap: 38,
			hoverpause: true,
			autoplay: 2500,
			breakpoints: {
				1024: {
					perView: 3,
				},
				800: {
					perView: 2,
				},
				480: {
					perView: 1,
					gap: 8,
					peek: {
						before: 0,
						after: 50,
					},
				},
			},
		});

		glide.mount();
	});
}
