import 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        const input = document.getElementById(toggle.dataset.passwordTarget);

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        const shouldShowPassword = input.type === 'password';

        input.type = shouldShowPassword ? 'text' : 'password';
        const icon = toggle.querySelector('i');

        if (icon) {
            icon.classList.toggle('bi-eye', !shouldShowPassword);
            icon.classList.toggle('bi-eye-slash', shouldShowPassword);
        }

        toggle.setAttribute('aria-label', `${shouldShowPassword ? 'Ocultar' : 'Mostrar'} contraseña`);
    });
});

const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');

if (deleteConfirmationModal) {
    let formToDelete;

    deleteConfirmationModal.addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;

        if (!(trigger instanceof HTMLElement)) {
            return;
        }

        formToDelete = trigger.closest('form');

        const message = trigger.dataset.deleteMessage;
        const messageElement = deleteConfirmationModal.querySelector('[data-delete-message]');

        if (message && messageElement) {
            messageElement.textContent = message;
        }
    });

    deleteConfirmationModal.querySelector('[data-confirm-delete]')?.addEventListener('click', () => {
        formToDelete?.requestSubmit();
    });

    deleteConfirmationModal.addEventListener('hidden.bs.modal', () => {
        formToDelete = undefined;
    });
}
