import { initPasswordToggle } from './auth-utils';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Inisialisasi Toggle Password (Otomatis deteksi semua form: Login, Register, & Admin User)
    initPasswordToggle();

    // 2. Inisialisasi Reusable Live Search Dropdown
    initLiveSearchSelect();
});

/**
 * Global Function: Panggil Toast Pop-up dari JavaScript (Opsional/AJAX)
 */
window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toastId = 'toast-' + Date.now();
    const isSuccess = type === 'success';

    const toastHtml = `
        <div id="${toastId}" 
             class="max-w-sm w-full bg-white rounded-2xl shadow-2xl border-2 p-4 flex items-center space-x-3 transition-all duration-300 transform translate-y-0 opacity-100 ${isSuccess ? 'border-emerald-500/40 text-emerald-900 shadow-emerald-500/10' : 'border-rose-500/40 text-rose-900 shadow-rose-500/10'}">
            <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center font-bold text-base shadow-sm ${isSuccess ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'}">
                ${isSuccess ? '✅' : '⚠️'}
            </div>
            <div class="flex-1 text-xs font-bold leading-relaxed">
                ${message}
            </div>
            <button onclick="document.getElementById('${toastId}').remove()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition font-bold text-sm focus:outline-none">
                ✕
            </button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', toastHtml);

    setTimeout(() => {
        const el = document.getElementById(toastId);
        if (el) {
            el.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => el.remove(), 300);
        }
    }, 6000);
};

/**
 * Global Live Search Dropdown (Vanilla JS)
 */
function initLiveSearchSelect() {
    const customSelects = document.querySelectorAll('[data-live-search="true"]');

    customSelects.forEach(container => {
        const triggerBtn = container.querySelector('.select-trigger-btn');
        const dropdownMenu = container.querySelector('.select-dropdown-menu');
        const searchInput = container.querySelector('.select-search-input');
        const realInput = container.querySelector('.select-real-input');
        const displayText = container.querySelector('.select-display-text');
        const optionItems = container.querySelectorAll('.select-option-item');

        if (!triggerBtn || !dropdownMenu) return;

        // Toggle Open/Close Dropdown
        triggerBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            
            // Tutup dropdown lain yang sedang terbuka
            document.querySelectorAll('.select-dropdown-menu').forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });

            const isHidden = dropdownMenu.classList.contains('hidden');
            if (isHidden) {
                dropdownMenu.classList.remove('hidden');
                if (searchInput) {
                    searchInput.value = '';
                    filterOptions(optionItems, '');
                    setTimeout(() => searchInput.focus(), 50);
                }
            } else {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Pilih Opsi
        optionItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                const text = this.getAttribute('data-text');

                if (realInput) realInput.value = id;
                if (displayText) displayText.textContent = text;
                
                optionItems.forEach(opt => opt.classList.remove('bg-blue-50', 'text-blue-600', 'font-bold'));
                this.classList.add('bg-blue-50', 'text-blue-600', 'font-bold');

                dropdownMenu.classList.add('hidden');
            });
        });

        // Live Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                filterOptions(optionItems, this.value.toLowerCase());
            });
        }
    });

    function filterOptions(items, query) {
        items.forEach(item => {
            const text = item.getAttribute('data-text').toLowerCase();
            if (text.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Close saat Klik di Luar
    document.addEventListener('click', function (e) {
        customSelects.forEach(container => {
            const dropdownMenu = container.querySelector('.select-dropdown-menu');
            if (dropdownMenu && !container.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
}