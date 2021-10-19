/* Arquivo Scripts Menus */

export function pa_remove(e) {
  var acx = document.querySelectorAll(".active");
  if (acx.length) {
    for (const item of acx) {
      if (item.children[1] !== e.nextElementSibling) {
        item.classList.remove("active");
        var painel = item.children[1];
        painel && (painel.style.maxHeight = null);
      }
    }
  }
}

export function pa_dropdown() {
  var acc = document.querySelectorAll(".pa-dropdown > a");
  for (const item of acc) {
    item.addEventListener("click", function() {
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

export function pa_action_menu() {
  var menu = document.querySelector("#pa_menu");
  menu.classList.toggle("ativo");
}

export function pa_number_of_columns_menu() {
  var itens = document.querySelectorAll(".dropdown-menu");

  itens.forEach(function(item) {
    if (item.childElementCount >= 10) {
      item.classList.add("pa-split-column-2");
    }
  });
}
