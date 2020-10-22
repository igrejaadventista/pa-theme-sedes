function pa_aumenta_texto(event) {
	event.preventDefault();
	var content = document.querySelector(".pa-content");
	if (!content.style.fontSize) {
		content.style.fontSize = "110%";
	} else {
		var tamanho = parseInt(content.style.fontSize.replace("%", ""));
		content.style.fontSize = tamanho + 10 + "%";
	}
}

function pa_diminui_texto(event) {
	event.preventDefault();
	var content = document.querySelector(".pa-content");
	if (!content.style.fontSize) {
		content.style.fontSize = "90%";
	} else {
		var tamanho = parseInt(content.style.fontSize.replace("%", ""));
		content.style.fontSize = tamanho - 10 + "%";
	}
}
