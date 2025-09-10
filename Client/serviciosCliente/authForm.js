const LOGIN_URL = '?controller=auth&action=login';
const REGISTER_URL = '?controller=auth&action=register';

function postJSON(url, body) {
  return fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'same-origin',
    body: JSON.stringify(body),
  }).then(async (r) => {
    const data = await r.json().catch(() => ({}));
    if (!r.ok) {
      const msg = data?.error || 'error_desconocido';
      throw new Error(msg);
    }
    return data;
  });
}

function showError(form, msg) {
  const box = form.querySelector('.form-error');
  if (box) {
    box.textContent = msg;
    box.style.color = '#ffb4b4';
    box.style.marginTop = '8px';
  } else {
    alert(msg);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const loginModal = document.getElementById('loginModal');
  const registerModal = document.getElementById('registerModal');

  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(loginForm);
      const usuario = (fd.get('usuario') || '').toString().trim();
      const contrasena = (fd.get('contrasena') || '').toString();

      if (!usuario || !contrasena) {
        showError(loginForm, 'faltan_campos');
        return;
      }

      try {
        const res = await postJSON('/api.php?r=/auth/login', { usuario, contrasena });
        console.log('login ok', res);
        if (loginModal) loginModal.style.display = 'none';
      } catch (err) {
        showError(loginForm, err.message);
      }
    });
  }

  if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(registerForm);
      const nombre = (fd.get('nombre') || '').toString().trim();
      const email = (fd.get('email') || '').toString().trim();
      const contrasena = (fd.get('contrasena') || '').toString();
      const contrasena2 = (fd.get('contrasena2') || '').toString();

      if (!nombre || !email || !contrasena || !contrasena2) {
        showError(registerForm, 'faltan_campos');
        return;
      }

      try {
        const res = await postJSON('/api.php?r=/auth/register', { nombre, email, contrasena, contrasena2 });
        console.log('register ok', res);
        if (registerModal) registerModal.style.display = 'none';
      } catch (err) {
        showError(registerForm, err.message);
      }
    });
  }
});