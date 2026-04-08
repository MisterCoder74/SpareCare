document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('search-form');
    const resultsContainer = document.getElementById('results-container');

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

        resultsContainer.innerHTML = professionals.map(p => `
            <div class="card prof-card">
                <img src="${p.photo ? '../../' + p.photo : 'https://via.placeholder.com/300x200?text=Foto+Profilo'}" alt="${p.first_name}" class="prof-photo">
                <h3 class="prof-name">${p.first_name} ${p.last_name}</h3>
                <div class="prof-location">${p.city} (${p.province})</div>
                <p class="prof-bio">${p.bio ? p.bio.substring(0, 100) + (p.bio.length > 100 ? '...' : '') : 'Nessuna descrizione fornita.'}</p>
                <div class="prof-footer">
                    <div class="prof-rate">${p.rates.hourly > 0 ? p.rates.hourly + '€/ora' : 'Tariffa N.D.'}</div>
                    <button class="btn btn-primary btn-sm contact-btn" 
                        data-id="${p.id}" 
                        data-name="${p.first_name} ${p.last_name}"
                        data-phone="${p.phone}"
                        data-email="${p.email}">Contatta</button>
                </div>
            </div>
        `).join('');

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
