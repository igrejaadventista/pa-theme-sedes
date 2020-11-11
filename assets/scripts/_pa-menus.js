/* Arquivo Scripts Menus */

function pa_remove(e) {
	var acx = document.querySelectorAll(".active");
	if (acx.length) {
		for (var i = 0; i < acx.length; i++) {
			if (acx[i].children[1] !== e.nextElementSibling) {
				acx[i].classList.remove("active");
				var painel = acx[i].children[1];
				painel && (painel.style.maxHeight = null);
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

			var painel = this.nextElementSibling;
			if (painel.style.maxHeight) {
				painel.style.maxHeight = null;
			} else {
				painel.style.maxHeight = painel.scrollHeight + "px";
			}
		});
	}
}

function pa_action_menu() {
	var menu = document.querySelector("#pa_menu");
	menu.classList.toggle("ativo");
}

function pa_number_of_columns_menu() {
	var itens = document.querySelectorAll(".dropdown-menu");

	itens.forEach(function (item) {
		if (item.childElementCount >= 10) {
			item.classList.add("pa-split-column-2");
		}
	});
}
