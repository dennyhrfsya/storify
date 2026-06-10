document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById('login-form');
    const btnLogin = document.getElementById('btn-login');
    const btnText = document.getElementById('btn-text');
    const btnLoader = document.getElementById('btn-loader');
    const btnReset = document.getElementById('btn-reset');

    if (!loginForm || !btnLogin) return;

    loginForm.addEventListener('submit', () => {
        if (btnReset) {
            btnReset.classList.remove('dx-btn-secondary');
            btnReset.classList.add('dx-btn-disabled');
        }

        if (btnText) {
            btnText.style.setProperty('display', 'none', 'important');
        }

        btnLogin.classList.add('is-loading');

        if (btnLoader) {
            btnLoader.style.setProperty('display', 'inline-block', 'important');
        }
    });
});
