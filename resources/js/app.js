import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.toggleDropdown = (dropdownId) => {
    const dropdown = document.getElementById(`post-options-dropdown-${dropdownId.split('-')[2]}`);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
};
