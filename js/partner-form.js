(() => {
  const form = document.getElementById('partner-signup');
  if (!form || form.dataset.enhanced === 'yes') return;
  form.dataset.enhanced = 'yes';
  const panels = [...form.querySelectorAll('.rb-form-step')];
  const labels = ['Dados da loja', 'Endereço', 'Acesso', 'Responsável'];
  const steps = [...form.querySelectorAll('.rb-progress li')];
  const status = form.querySelector('.rb-step-status');
  const error = form.querySelector('#rb-form-error');
  const back = form.querySelector('[data-action=back]');
  const next = form.querySelector('[data-action=next]');
  const submit = form.querySelector('[data-action=submit]');
  let current = 0;

  function onlyDigits(value) { return value.replace(/\D/g, ''); }
  function validCnpj(value) {
    const text = onlyDigits(value);
    if (!/^\d{14}$/.test(text) || /^(\d)\1{13}$/.test(text)) return false;
    const digits = text.split('').map(Number);
    const compute = weights => {
      const mod = weights.reduce((sum, weight, i) => sum + weights[i] * digits[i], 0) % 11;
      return mod < 2 ? 0 : 11 - mod;
    };
    return digits[12] === compute([5,4,3,2,9,8,7,6,5,4,3,2]) &&
      digits[13] === compute([6,5,4,3,2,9,8,7,6,5,4,3,2]);
  }
  window.rbValidCnpj = validCnpj;

  function message(text) {
    error.textContent = text || '';
    error.hidden = !text;
  }
  function show(index) {
    current = index;
    panels.forEach((panel, i) => { panel.hidden = i !== current; });
    steps.forEach((step, i) => {
      step.classList.toggle('is-current', i === current);
      if (i === current) step.setAttribute('aria-current', 'step');
      else step.removeAttribute('aria-current');
    });
    status.textContent = 'Etapa ' + (current + 1) + ' de ' + panels.length + ' — ' + labels[current];
    back.hidden = current === 0;
    next.hidden = current === panels.length - 1;
    submit.hidden = current !== panels.length - 1;
    message('');
    form.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth', block: 'start' });
  }
  function valid(index) {
    const panel = panels[index];
    for (const input of panel.querySelectorAll('input,select,textarea')) {
      if (!input.checkValidity()) { input.reportValidity(); input.focus(); return false; }
    }
    if (index === 0 && !validCnpj(form.elements.cnpj.value)) {
      message('Confira os dígitos do CNPJ. O número informado não é válido.');
      form.elements.cnpj.focus();
      return false;
    }
    if (index === 2 && (form.elements.email.value.trim().toLowerCase() !== form.elements.email2.value.trim().toLowerCase() ||
      form.elements.password.value !== form.elements.password2.value)) {
      message('Os campos de confirmação devem ser iguais aos originais.');
      return false;
    }
    message('');
    return true;
  }

  next.addEventListener('click', () => { if (valid(current)) show(current + 1); });
  back.addEventListener('click', () => show(Math.max(0, current - 1)));
  form.addEventListener('submit', event => {
    for (let i = 0; i < panels.length; i++) {
      if (!valid(i)) { event.preventDefault(); show(i); valid(i); return; }
    }
  });
  form.querySelector('[data-action=cep]').addEventListener('click', async () => {
    const cep = onlyDigits(form.elements.cep.value);
    if (cep.length !== 8) { message('Informe um CEP com 8 dígitos.'); return; }
    const button = form.querySelector('[data-action=cep]');
    button.disabled = true;
    try {
      const response = await fetch('https://viacep.com.br/ws/' + cep + '/json/');
      if (!response.ok) throw new Error('CEP');
      const data = await response.json();
      if (data.erro) throw new Error('CEP');
      for (const [field, key] of Object.entries({ city: 'localidade', state: 'uf', district: 'bairro', address: 'logradouro' })) {
        if (data[key] && form.elements[field]) form.elements[field].value = data[key];
      }
      message('');
    } catch { message('CEP não encontrado. Preencha o endereço manualmente.'); }
    finally { button.disabled = false; }
  });
  show(0);
})();
