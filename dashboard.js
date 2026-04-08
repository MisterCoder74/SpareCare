document.addEventListener('DOMContentLoaded', async () => {
    const profileForm = document.getElementById('profile-form');
    const servicesForm = document.getElementById('services-form');
    const availabilityForm = document.getElementById('availability-form');
    const photoInput = document.getElementById('photo-input');
    const photoPreview = document.getElementById('profile-photo-preview');

    // Load current data
    try {
        const professional = await Utils.fetchAPI('api/get-profile.php');
        const profile = professional.profile;

        // Fill Profile Form
        if (profile.photo) photoPreview.src = profile.photo;
        document.getElementById('first_name').value = profile.first_name || '';
        document.getElementById('last_name').value = profile.last_name || '';
        document.getElementById('phone').value = profile.phone || '';
        document.getElementById('contact_email').value = profile.contact_email || '';
        document.getElementById('bio').value = profile.bio || '';
        document.getElementById('city').value = profile.location.city || '';
        document.getElementById('province').value = profile.location.province || '';

        // Fill Services Form
        document.getElementById('hourly_rate').value = profile.rates.hourly || 0;
        document.getElementById('daily_rate').value = profile.rates.daily || 0;
        document.getElementById('monthly_discount').checked = profile.monthly_discount || false;

        const serviceCheckboxes = servicesForm.querySelectorAll('input[name="services[]"]');
        serviceCheckboxes.forEach(cb => {
            if (profile.services.includes(cb.value)) cb.checked = true;
        });

        // Fill Availability Form
        for (const [key, value] of Object.entries(profile.availability)) {
            const cb = availabilityForm.querySelector(`input[name="availability[${key}]"]`);
            if (cb && value) cb.checked = true;
        }

    } catch (error) {
        Utils.showAlert('Errore nel caricamento dei dati: ' + error.message);
    }

    // Photo Upload
    photoInput.addEventListener('change', async () => {
        if (!photoInput.files[0]) return;

        const formData = new FormData();
        formData.append('photo', photoInput.files[0]);

        try {
            const response = await fetch('api/upload-photo.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                photoPreview.src = data.photo_url;
                Utils.showAlert('Foto aggiornata con successo', 'success');
            } else {
                throw new Error(data.error);
            }
        } catch (error) {
            Utils.showAlert(error.message);
        }
    });

    // Profile Save
    profileForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(profileForm);
        const profileUpdate = {
            profile: {
                first_name: formData.get('first_name'),
                last_name: formData.get('last_name'),
                phone: formData.get('phone'),
                contact_email: formData.get('contact_email'),
                bio: formData.get('bio'),
                location: {
                    city: formData.get('city'),
                    province: formData.get('province')
                }
            }
        };

        try {
            await Utils.fetchAPI('api/update-profile.php', {
                method: 'POST',
                body: JSON.stringify(profileUpdate)
            });
            Utils.showAlert('Profilo salvato con successo', 'success');
        } catch (error) {
            Utils.showAlert(error.message);
        }
    });

    // Services Save
    servicesForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(servicesForm);
        const services = formData.getAll('services[]');
        const hourly_rate = parseFloat(formData.get('hourly_rate'));
        const daily_rate = parseFloat(formData.get('daily_rate'));
        const monthly_discount = formData.has('monthly_discount');

        const profileUpdate = {
            profile: {
                services: services,
                monthly_discount: monthly_discount,
                rates: {
                    hourly: hourly_rate,
                    daily: daily_rate,
                    currency: 'EUR'
                }
            }
        };

        try {
            await Utils.fetchAPI('api/update-profile.php', {
                method: 'POST',
                body: JSON.stringify(profileUpdate)
            });
            Utils.showAlert('Servizi e tariffe aggiornati', 'success');
        } catch (error) {
            Utils.showAlert(error.message);
        }
    });

    // Availability Save
    availabilityForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(availabilityForm);
        const availability = {
            morning: formData.has('availability[morning]'),
            afternoon: formData.has('availability[afternoon]'),
            evening: formData.has('availability[evening]'),
            night: formData.has('availability[night]'),
            weekend: formData.has('availability[weekend]'),
            holidays: formData.has('availability[holidays]')
        };

        const profileUpdate = {
            profile: { availability: availability }
        };

        try {
            await Utils.fetchAPI('api/update-profile.php', {
                method: 'POST',
                body: JSON.stringify(profileUpdate)
            });
            Utils.showAlert('Disponibilità aggiornata', 'success');
        } catch (error) {
            Utils.showAlert(error.message);
        }
    });
});
