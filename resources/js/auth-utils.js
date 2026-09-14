/**
 * Utility Function: Toggle Password Visibility
 * @param {string} inputId - ID elemen input password
 * @param {string} btnId - ID elemen button toggle
 * @param {string} openIconId - ID ikon mata terbuka
 * @param {string} slashIconId - ID ikon mata dicoret
 */
export function initPasswordToggle(inputId, btnId, openIconId, slashIconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleBtn = document.getElementById(btnId);
    const eyeOpenIcon = document.getElementById(openIconId);
    const eyeSlashIcon = document.getElementById(slashIconId);

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            
            if (isPassword) {
                passwordInput.setAttribute('type', 'text');
                eyeOpenIcon?.classList.add('hidden');
                eyeSlashIcon?.classList.remove('hidden');
            } else {
                passwordInput.setAttribute('type', 'password');
                eyeOpenIcon?.classList.remove('hidden');
                eyeSlashIcon?.classList.add('hidden');
            }
        });
    }
}