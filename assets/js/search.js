document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('search-form');
    const resultsContainer = document.getElementById('results-container');

    // Service labels mapping
    const serviceLabels = {
        'assistenza_anziani': 'Assistenza Anziani',
        'assistenza_disabili': 'Assistenza Disabili',
        'baby_sitting': 'Baby Sitting',
        'colf': 'Collaboratore Domestico',
        'badante': 'Badante',
        'fisioterapia': 'Fisioterapia',
        'infermieristica': 'Assistenza Infermieristica'
    };

    // Availability labels mapping
    const availabilityLabels = {
        'morning': 'Mattina',
        'afternoon': 'Pomeriggio',
        'evening': 'Sera',
        'night': 'Notte',
        'weekend': 'Weekend',
        'holidays': 'Festivi'
    };

    // Availability icons mapping
    const availabilityIcons = {
        'morning': '🌅',
        'afternoon': '☀️',
        'evening': '🌆',
        'night': '🌙',
        'weekend': '📅',
        'holidays': '🎉'
    };

    const loadProfessionals = async (filters = {}) => {
        resultsContainer.innerHTML = '<div class="loading-message">Ricerca in corso...</div>';

        const params = new URLSearchParams(filters);
        try {
            const professionals = await Utils.fetchAPI(`../../api/professionals/list.php?${params.toString()}`);
            renderResults(professionals);
        } catch (error) {
            resultsContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    };

    const renderResults = (professionals) => {
        if (professionals.length === 0) {
            resultsContainer.innerHTML = '<div class="alert alert-light">Nessun professionista trovato con i criteri selezionati.</div>';
            return;
        }

        resultsContainer.innerHTML = professionals.map(p => {
            // Build badges HTML
            const badgesHtml = [];
            if (p.availability?.night) {
                badgesHtml.push('<span class="badge badge-night">🌙 Disponibile di notte</span>');
            }
            if (p.monthly_discount) {
                badgesHtml.push('<span class="badge badge-discount">💰 Sconti mensili</span>');
            }
            const badgesSection = badgesHtml.length > 0
                ? `<div class="prof-badges">${badgesHtml.join('')}</div>`
                : '';

            // Build services HTML
            let servicesHtml = '';
            if (p.services && p.services.length > 0) {
                const displayedServices = p.services.slice(0, 3);
                const moreCount = p.services.length - 3;
                const servicesList = displayedServices.map(s =>
                    `<span class="service-tag">${serviceLabels[s] || s}</span>`
                ).join('');
                const moreServices = moreCount > 0
                    ? `<span class="service-tag service-tag-more">+${moreCount} altri</span>`
                    : '';
                servicesHtml = `<div class="prof-services">${servicesList}${moreServices}</div>`;
            }

            // Build availability HTML
            let availabilityHtml = '';
            if (p.availability) {
                const activeAvailabilities = Object.entries(p.availability)
                    .filter(([key, value]) => value === true)
                    .map(([key]) => `<span class="availability-item" title="${availabilityLabels[key]}">${availabilityIcons[key]} ${availabilityLabels[key]}</span>`);
                if (activeAvailabilities.length > 0) {
                    availabilityHtml = `<div class="prof-availability">${activeAvailabilities.join('')}</div>`;
                }
            }

            // Build rates HTML
            const hourlyRate = p.rates?.hourly > 0 ? `€${p.rates.hourly}/ora` : null;
            const dailyRate = p.rates?.daily > 0 ? `€${p.rates.daily}/giorno` : null;
            let ratesHtml = '';
            if (hourlyRate || dailyRate) {
                const ratesParts = [];
                if (hourlyRate) ratesParts.push(`<span class="rate-item"><strong>${hourlyRate}</strong></span>`);
                if (dailyRate) ratesParts.push(`<span class="rate-item daily-rate">${dailyRate}</span>`);
                ratesHtml = `<div class="prof-rates">${ratesParts.join('')}</div>`;
            } else {
                ratesHtml = `<div class="prof-rates"><span class="rate-item">Tariffa N.D.</span></div>`;
            }

            // Build phone HTML
            const phoneHtml = p.phone
                ? `<div class="prof-phone">📞 <a href="tel:${p.phone}">${p.phone}</a></div>`
                : '';

            // Build bio HTML (truncated to 150 chars)
            const bioText = p.bio
                ? (p.bio.length > 150 ? p.bio.substring(0, 150) + '...' : p.bio)
                : 'Nessuna descrizione fornita.';

            // Build contact button (only if email exists)
            const contactButton = p.email
                ? `<button class="btn btn-primary btn-sm contact-btn"
                    data-id="${p.id}"
                    data-name="${p.first_name} ${p.last_name}"
                    data-phone="${p.phone || ''}"
                    data-email="${p.email}">Contatta via Email</button>`
                : '';

            // Photo path - ensure correct relative path
            const photoSrc = p.photo
                ? `../../${p.photo}`
                : 'https://via.placeholder.com/300x200?text=Foto+Profilo';

            return `
                <div class="card prof-card">
                    <div class="prof-photo-container">
                        <img src="${photoSrc}" alt="${p.first_name} ${p.last_name}" class="prof-photo">
                        ${badgesSection}
                    </div>
                    <div class="prof-content">
                        <h3 class="prof-name">${p.first_name} ${p.last_name}</h3>
                        <div class="prof-location">📍 ${p.city} (${p.province})</div>
                        ${phoneHtml}
                        <p class="prof-bio">${bioText}</p>
                        ${servicesHtml}
                        ${availabilityHtml}
                        ${ratesHtml}
                        ${contactButton}
                    </div>
                </div>
            `;
        }).join('');

        // Attach contact events
        document.querySelectorAll('.contact-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                window.openContactModal(btn.dataset);
            });
        });
    };

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(searchForm);
        loadProfessionals(Object.fromEntries(formData.entries()));
    });

    // Initial load
    loadProfessionals();
});
