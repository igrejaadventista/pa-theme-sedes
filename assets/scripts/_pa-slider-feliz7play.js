/* Scripsts Slider Feliz7Play */

function pa_slider_feliz7play() {
	var select = ".pa-glide-feliz7play";

	var node = document.querySelector(select);
	if (document.body.contains(node)) {
		var glide = new Glide(select, {
			type: "carousel",
			startAt: 1,
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
	}
}
