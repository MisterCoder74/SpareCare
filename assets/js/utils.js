const Utils = {
    async fetchAPI(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        };
        
        const response = await fetch(url, { ...defaultOptions, ...options });
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Errore di sistema');
        }
        
        return data;
    },

    showAlert(message, type = 'danger') {
        const container = document.querySelector('.container');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        
        container.prepend(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
};
