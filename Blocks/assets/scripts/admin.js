function syncRemoteData(event) {
  event.preventDefault();

  // Get results
  xhr = jQuery.ajax({
    url: ajaxurl,
    type: "post",
    data: {
      action: "blocks/update_remote_data"
    }
  });

  alert("Sincronização em progresso!");
}
