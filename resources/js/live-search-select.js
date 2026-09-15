/**
 * Global Live Search Dropdown (Vanilla JS)
 * Mendukung reused component di seluruh modul Portal XI PPLG 2
 */
export function initLiveSearchSelect() {
    const customSelects = document.querySelectorAll('[data-live-search="true"]');

    customSelects.forEach(container => {
        const triggerBtn = container.querySelector('.select-trigger-btn');
        const dropdownMenu = container.querySelector('.select-dropdown-menu');
        const searchInput = container.querySelector('.select-search-input');
        const realInput = container.querySelector('.select-real-input');
        const displayText = container.querySelector('.select-display-text');
        const optionItems = container.querySelectorAll('.select-option-item');

        if (!triggerBtn || !dropdownMenu) return;

        // 1. Toggle Dropdown
        triggerBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            
            // Tutup dropdown lain yang mungkin sedang terbuka
            document.querySelectorAll('.select-dropdown-menu').forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });

            const isHidden = dropdownMenu.classList.contains('hidden');
            if (isHidden) {
                dropdownMenu.classList.remove('hidden');
                if (searchInput) {
                    searchInput.value = '';
                    filterOptions(optionItems, '');
                    searchInput.focus();
                }
            } else {
                dropdownMenu.classList.add('hidden');
            }
        });

        // 2. Pilih Opsi
        optionItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                const text = this.getAttribute('data-text');

                if (realInput) realInput.value = id;
                if (displayText) displayText.textContent = text;
                
                // Active Styling State
                optionItems.forEach(opt => opt.classList.remove('bg-blue-50', 'text-blue-600', 'font-bold'));
                this.classList.add('bg-blue-50', 'text-blue-600', 'font-bold');

                dropdownMenu.classList.add('hidden');
            });
        });

        // 3. Filter Pencarian Real-time
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                filterOptions(optionItems, this.value.toLowerCase());
            });
        }
    });

    // Helper Filter
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

    // 4. Close saat Klik Luar
    document.addEventListener('click', function (e) {
        customSelects.forEach(container => {
            const dropdownMenu = container.querySelector('.select-dropdown-menu');
            if (dropdownMenu && !container.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
}