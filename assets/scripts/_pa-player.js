export function pa_play(event, element) {
	event.preventDefault();
	var audio = document.querySelector("#pa-accessibility-player");

	if (!audio.paused) {
		console.log("Pause");
		audio.pause();
	} else {
		console.log("Play");
		audio.play();
	}

	var icone = element.firstElementChild;
	icone.classList.toggle("fa-volume-up");
	icone.classList.toggle("fa-pause-circle");
}
