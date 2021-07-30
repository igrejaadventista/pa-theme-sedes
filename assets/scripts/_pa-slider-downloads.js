/* Scripsts Slider Videos */

function pa_slider_downloads() {
	var select = ".pa-glide-downloads";

	var node = document.querySelector(select);
	if (document.body.contains(node)) {
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
	}
}
