/* Navegação pública: roteamento restrito a templates conhecidos. */
jQuery(function ($) {
  const allowedPages = new Set([
    'index', 'restaurant', 'market', 'acess',
    'form-restaurant', 'form-market', 'finish'
  ]);
  const requestedPage = new URLSearchParams(window.location.search).get('pag') || 'index';
  const page = allowedPages.has(requestedPage) ? requestedPage : 'index';
  const $main = $('main');
  const $loading = $('#loading');

  if (page === 'acess') {
    $('footer').hide();
  }

  $.ajax({
    url: './view/' + page + '.html',
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
      const $error = $('<section>', { class: 'loadError', role: 'alert' })
        .append($('<h1>').text('Não foi possível carregar esta página.'))
        .append($('<p>').text('Verifique sua conexão e tente novamente.'))
        .append($('<a>', { href: './index.html' }).text('Voltar ao início'));
      $main.empty().append($error);
    },
    complete: function () {
      $main.removeAttr('aria-busy');
      $loading.stop(true, true).fadeOut(120);
    }
  });
});
