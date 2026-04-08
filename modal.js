document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('contact-modal');
    const closeBtn = document.querySelector('.close-modal');
    const contactForm = document.getElementById('contact-form');

    window.openContactModal = (data) => {
        document.getElementById('modal-title').textContent = `Contatta ${data.name}`;
        document.getElementById('modal-phone').textContent = data.phone || 'Non fornito';
        document.getElementById('modal-email').textContent = data.email || 'Non fornito';
        document.getElementById('contact-prof-id').value = data.id;
        modal.style.display = 'block';
    };

    closeBtn.onclick = () => {
        modal.style.display = 'none';
    };

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData.entries());

        try {
            await Utils.fetchAPI('api/send-email.php', {
                method: 'POST',
                body: JSON.stringify(data)
            });
            Utils.showAlert('Messaggio inviato con successo!', 'success');
            modal.style.display = 'none';
            contactForm.reset();
        } catch (error) {
            Utils.showAlert(error.message);
        }
    });
});
