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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const url = this.action;
            const method = this.querySelector('input[name="_method"]')?.value || 'POST';
            const token = this.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const button = this.querySelector('button');
                    const svg = button.querySelector('svg');
                    const count = button.querySelector('.likes-count');

                    if (method === 'DELETE') {
                        // Change to like state
                        this.action = this.action.replace('unlike', 'like');
                        svg.classList.remove('text-blue-500');
                        svg.setAttribute('fill', 'none');
                        count.classList.remove('text-blue-500');
                        this.querySelector('input[name="_method"]')?.remove();
                    } else {
                        // Change to unlike state
                        this.action = this.action.replace('like', 'unlike');
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        this.appendChild(methodInput);
                        svg.classList.add('text-blue-500');
                        svg.setAttribute('fill', 'currentColor');
                        count.classList.add('text-blue-500');
                    }

                    count.textContent = data.likes_count;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});
