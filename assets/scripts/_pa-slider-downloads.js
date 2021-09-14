/* Scripsts Slider Videos */

function pa_slider_downloads() {
	var nodes = document.querySelectorAll('.pa-glide-downloads');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
		var glide = new Glide(node, {
			type: "carousel",
			perView: 4,
			startAt: 0,
			gap: 24,
			hoverpause: true,
			//autoplay: 2500,
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
						after: 129,
					},
				},
			},
		});

		glide.mount();
	});
}
