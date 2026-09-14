// Hapus atau comment baris bootstrap jika file tidak ada
// import './bootstrap';

import { initPasswordToggle } from './auth-utils';

document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi otomatis jika elemen toggle password ada di halaman
    initPasswordToggle('passwordInput', 'togglePasswordBtn', 'eyeOpenIcon', 'eyeSlashIcon');
});