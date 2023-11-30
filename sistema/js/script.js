function jConfirmDelete(clientId, clientCode) {
  $('#confirmDeleteModal' + clientId).modal('hide');
  $('#loadingModal').modal('show');

  $.ajax({
    url: 'delete_client.php',
    type: 'POST',
    data: { id: clientId },
    success: function (response) {
      $('#loadingModal').modal('hide');

      let objeto = JSON.parse(response)

      $(`tr[data-codigo=${objeto.id}]`).remove()
    },
    error: function (xhr, status, error) {
      $('#loadingModal').modal('hide');

      alert('Erro ao excluir o cliente. Tente novamente.');
    }
  });
}

function filtrar() {
  var formulario = document.getElementById('filtro');

  formulario.submit();
}

function limparFiltro() {
  var formulario = document.getElementById('filtro');

  formulario.submit();
}