<?php
require_once __DIR__ . '/../../includes/auth-check.php';
$extra_css = ['dashboard'];
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="dashboard-header">
    <h1>Il Tuo Profilo Professionale</h1>
    <p>Gestisci le tue informazioni, i servizi che offri e la tua disponibilità.</p>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Informazioni Personali</h3>
        <form id="profile-form">
            <div class="form-group">
                <label>Foto Profilo</label>
                <div class="photo-upload">
                    <img id="profile-photo-preview" src="https://via.placeholder.com/100x100?text=Foto" alt="Anteprima" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; display: block; margin-bottom: 1rem;">
                    <input type="file" id="photo-input" accept="image/*">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label for="first_name">Nome</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Cognome</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label for="phone">Telefono</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact_email">Email di contatto</label>
                <input type="email" id="contact_email" name="contact_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bio">Biografia / Descrizione</label>
                <textarea id="bio" name="bio" class="form-control" rows="4"></textarea>
            </div>
            
            <h3>Località</h3>
            <div class="grid-2">
                <div class="form-group">
                    <label for="city">Città</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="province">Provincia (Sigla)</label>
                    <input type="text" id="province" name="province" class="form-control" maxlength="2" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salva Informazioni</button>
        </form>
    </div>

    <div>
        <div class="card">
            <h3>Tariffe e Servizi</h3>
            <form id="services-form">
                <div class="grid-2">
                    <div class="form-group">
                        <label for="hourly_rate">Tariffa Oraria (€)</label>
                        <input type="number" id="hourly_rate" name="hourly_rate" class="form-control" min="0">
                    </div>
                    <div class="form-group">
                        <label for="daily_rate">Tariffa Giornaliera (€)</label>
                        <input type="number" id="daily_rate" name="daily_rate" class="form-control" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Servizi Offerti</label>
                    <div class="services-grid">
                        <?php foreach (DEFAULT_SERVICES as $key => $label): ?>
                            <label class="checkbox-label">
                                <input type="checkbox" name="services[]" value="<?php echo $key; ?>">
                                <?php echo $label; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Aggiorna Servizi</button>
            </form>
        </div>

        <div class="card">
            <h3>Disponibilità</h3>
            <form id="availability-form">
                <div class="availability-grid">
                    <?php foreach (AVAILABILITY_OPTIONS as $key => $label): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="availability[<?php echo $key; ?>]" value="true">
                            <?php echo $label; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Salva Disponibilità</button>
            </form>
        </div>
    </div>
</div>

<?php 
$extra_js = ['dashboard'];
require_once __DIR__ . '/../../includes/footer.php'; 
?>
