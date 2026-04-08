document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const logoutBtn = document.getElementById('logout-btn');

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                await Utils.fetchAPI('api/login.php', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });
                window.location.href = 'dashboard.html';
            } catch (error) {
                Utils.showAlert(error.message);
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(registerForm);
            const data = Object.fromEntries(formData.entries());

            try {
                await Utils.fetchAPI('api/register.php', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });
                window.location.href = 'dashboard.html';
            } catch (error) {
                Utils.showAlert(error.message);
            }
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
                await Utils.fetchAPI('api/logout.php', { method: 'POST' });
                window.location.href = 'index.html';
            } catch (error) {
                console.error('Logout failed', error);
            }
        });
    }
});
