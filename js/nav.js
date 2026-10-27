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
      // Static landing pages obtain a server-side CSRF token only when submitted.
      $main.find('form[action]').on('submit.rbCsrf', async function (event) {
        if (event.isDefaultPrevented()) return; // preserve validation in form.js
        const form = this;
        const action = new URL(form.getAttribute('action'), window.location.href);
        if (action.origin !== location.origin ||
            !['authentication.php', 'insert_restaurant.php', 'insert_market.php']
              .includes(action.pathname.split('/').pop())) return;
        event.preventDefault();
        const submit = $(form).find('[type="submit"]').prop('disabled', true);
        try {
          const response = await fetch('./csrf.php', { credentials: 'same-origin', cache: 'no-store' });
          if (!response.ok) throw new Error('CSRF endpoint unavailable');
          const body = await response.json();
          if (typeof body.token !== 'string' || !body.token) throw new Error('Invalid CSRF token');
          let input = form.querySelector('input[name="_csrf"]');
          if (!input) {
            input = document.createElement('input');
            input.type = 'hidden'; input.name = '_csrf'; form.appendChild(input);
          }
          input.value = body.token;
          HTMLFormElement.prototype.submit.call(form);
        } catch (_error) {
          submit.prop('disabled', false);
          const alert = $('<p>', { role: 'alert', class: 'rb-form-error' })
            .text('Não foi possível validar a sessão. Verifique o servidor PHP e tente novamente.');
          $(form).find('.rb-form-error').remove();
          $(form).prepend(alert);
        }
      });
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
