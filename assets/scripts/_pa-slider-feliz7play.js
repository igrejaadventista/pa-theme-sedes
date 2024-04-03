/* Scripsts Slider Feliz7Play */
import Glide from '@glidejs/glide';

export function pa_slider_feliz7play() {
	var nodes = document.querySelectorAll('.pa-glide-feliz7play');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
    
    var autoPlay = node.dataset.autoplay,
      peekFormat = node.dataset.format;

    console.log(peekFormat)
    
		var glide = new Glide(node, {
			type: "carousel",
			startAt: 0,
			perView: 3,
			gap: 38,
			hoverpause: true,
			autoplay: autoPlay,
      peek: {
        before: peekFormat,
        after: peekFormat,
      },
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
						after: peekFormat,
					},
				},
			},
		});

		glide.mount();
	});
}
