/**
 * Utility Function: Toggle Password Visibility (Mendukung Multi-Form & Custom ID)
 */
export function initPasswordToggle() {
    // 1. Tangani komponen dengan atribut data-toggle-password (Register / Form User)
    const dataToggleButtons = document.querySelectorAll('[data-toggle-password]');
    dataToggleButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-toggle-password');
            const passwordInput = document.getElementById(targetId);
            if (!passwordInput) return;

            toggleInputVisibility(passwordInput, this);
        });
    });

    // 2. Backward Compatibility: Tangani Login Form bawaan (ID: togglePasswordBtn)
    const loginBtn = document.getElementById('togglePasswordBtn');
    const loginInput = document.getElementById('passwordInput') || document.getElementById('password');
    if (loginBtn && loginInput && !loginBtn.hasAttribute('data-toggle-password')) {
        loginBtn.addEventListener('click', function (e) {
            e.preventDefault();
            toggleInputVisibility(loginInput, this);
        });
    }
}

// Helper untuk switch type input & icon SVG
function toggleInputVisibility(inputEl, buttonEl) {
    const isPassword = inputEl.getAttribute('type') === 'password';
    inputEl.setAttribute('type', isPassword ? 'text' : 'password');

    const eyeOpen = buttonEl.querySelector('#eyeOpenIcon, .eye-open-icon');
    const eyeSlash = buttonEl.querySelector('#eyeSlashIcon, .eye-slash-icon');

    if (isPassword) {
        eyeOpen?.classList.add('hidden');
        eyeSlash?.classList.remove('hidden');
    } else {
        eyeOpen?.classList.remove('hidden');
        eyeSlash?.classList.add('hidden');
    }
}