/* Scripsts Slider Feliz7Play */

function pa_slider_destaques() {
	var glide = new Glide(".pa-glide-videos", {
		type: "carousel",
		perView: 5,
		startAt: 1,
		gap: 38,
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
