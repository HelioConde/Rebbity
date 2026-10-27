/* Navegação do portal legado: evita caminhos arbitrários no carregamento AJAX. */
jQuery(function ($) {
  const availablePages = new Set(['menu', 'category']);
  const requestedPage = new URLSearchParams(window.location.search).get('pag') || 'index';
  const page = requestedPage === 'index' ? 'menu' : requestedPage;
  const $main = $('main');
  const $loading = $('#loading');

  function showMessage(title, message) {
    const $message = $('<section>', { class: 'loadError', role: 'alert' })
      .append($('<h1>').text(title))
      .append($('<p>').text(message))
      .append($('<a>', { href: './index.php?pag=menu' }).text('Voltar ao cardápio'));
    $main.empty().append($message);
  }

  if (!availablePages.has(page)) {
    showMessage('Seção ainda indisponível', 'Esta parte do portal legado ainda não está implementada.');
    $loading.hide();
    return;
  }

  $.ajax({
    url: './view/' + page + '.php',
    method: 'GET',
    dataType: 'html',
    beforeSend: function () {
      $main.attr('aria-busy', 'true');
      $loading.show();
    },
    success: function (html) {
      $main.html(html).css('min-height', 'auto');
    },
    error: function () {
      showMessage('Não foi possível carregar esta página.', 'Verifique sua conexão ou se o servidor PHP está funcionando.');
    },
    complete: function () {
      $main.removeAttr('aria-busy');
      $loading.stop(true, true).fadeOut(120);
    }
  });
});
