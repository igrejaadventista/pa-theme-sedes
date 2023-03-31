function syncRemoteData(event) {
  syncBlocks();
  syncTaxonomies();

  checkEvent(event);
}

function syncBlocks(event = null) {
  // Get results
  jQuery.ajax({
    url: window.ajaxurl,
    type: 'post',
    data: {
      action: 'blocks/update_remote_data',
    },
  });

  checkEvent(event);
}

function syncTaxonomies(event) {
  // Get results
  jQuery.ajax({
    url: window.ajaxurl,
    type: 'post',
    data: {
      action: 'sync/taxonomies',
    },
  });

  checkEvent(event);
}

function checkEvent(event) {
  if(event) {
    event.preventDefault();
    alert("Sincronização em progresso!");
  }
}
