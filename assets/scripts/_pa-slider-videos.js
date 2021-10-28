/* Scripsts Slider Videos */
import Glide from "@glidejs/glide";

export function pa_slider_videos() {
  var nodes = document.querySelectorAll(".pa-glide-videos");

  if (!nodes.length) return;

  nodes.forEach(function(node) {
    var glide = new Glide(node, {
      type: "carousel",
      touchAngle: 120,
      perView: 5,
      startAt: 0,
      gap: 24,
      breakpoints: {
        1024: {
          perView: 3
        },
        800: {
          perView: 2
        },
        480: {
          perView: 1,
          gap: 8,
          peek: {
            before: 0,
            after: 129
          }
        }
      }
    });

    glide.mount();
  });
}
