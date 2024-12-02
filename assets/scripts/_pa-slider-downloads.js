/* Scripsts Slider Videos */
import Glide from '@glidejs/glide';

export function pa_slider_downloads() {
	var nodes = document.querySelectorAll('.pa-glide-downloads');

	if (!nodes.length)
		return;

	nodes.forEach(function (node) {
		var autoPlay = node.dataset.autoplay === undefined ? 2500 : node.dataset.autoplay ,
			peekFormat = node.dataset.format === undefined ? 1 : node.dataset.format;

		var glide = new Glide(node, {
			type: "carousel",
			perView: 4,
			startAt: 0,
			gap: 24,
			hoverpause: true,
			autoplay: autoPlay,
			peek: {
				before: peekFormat,
				after: peekFormat,
			},
			breakpoints: {
				1024: {
					perView: 3,
					peek: {
						before: 0,
						after: peekFormat,
					},
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

		/**
		 * Returns the position of the slide controls after the lib loads.
		 */
		glide.on(['mount.after'], function () {
			var getSlideHeight = node.getElementsByClassName('glide__slide')[0].offsetHeight,
				getArrows = node.querySelectorAll('.pa-arrows-up');

			if (!getArrows.length || !getSlideHeight)
				return;

			getArrows.forEach(function (control) {
				control.style.marginTop = -(getSlideHeight + 64) + "px"
			});
		});

		glide.mount();
	});
}