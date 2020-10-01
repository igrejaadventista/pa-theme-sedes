/* Arquivo Scripts Menus */

function pa_remove(e) {
	var acx = document.querySelectorAll(".active");
	if (acx.length) {
		for (var i = 0; i < acx.length; i++) {
			if (acx[i].children[1] !== e.nextElementSibling) {
				acx[i].classList.remove("active");
				var panel = acx[i].children[1];
				panel.style.maxHeight = null;
			}
		}
	}
}

function pa_dropdown() {
	var acc = document.querySelectorAll(".pa-dropdown > a");
	for (var i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			pa_remove(this);
			this.parentElement.classList.toggle("active");

			var panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			}
		});
	}
}

function pa_action_menu() {
	var menu = document.querySelector("#pa_menu");
	menu.classList.toggle("ativo");
}
