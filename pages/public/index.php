<?php
$extra_css = ['search'];
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="search-hero">
    <h1>Trova l'assistenza perfetta per te</h1>
    <p>Cerca tra centinaia di professionisti qualificati nella tua zona.</p>
    
    <div class="search-box card">
        <form id="search-form" class="grid-3">
            <div class="form-group">
                <label for="city-search">Città</label>
                <input type="text" id="city-search" name="city" class="form-control" placeholder="es. Milano">
            </div>
            <div class="form-group">
                <label for="service-search">Servizio</label>
                <select id="service-search" name="service" class="form-control">
                    <option value="">Tutti i servizi</option>
                    <?php foreach (DEFAULT_SERVICES as $key => $label): ?>
                        <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="availability-search">Disponibilità</label>
                <select id="availability-search" name="availability" class="form-control">
                    <option value="">Qualsiasi</option>
                    <?php foreach (AVAILABILITY_OPTIONS as $key => $label): ?>
                        <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="search-actions">
                <button type="submit" class="btn btn-primary btn-block">Cerca</button>
            </div>
        </form>
    </div>
</div>

<div id="results-container" class="results-grid">
    <!-- Results will be injected here -->
    <div class="loading-message">Caricamento professionisti...</div>
</div>

<!-- Modal Contatto -->
<div id="contact-modal" class="modal">
    <div class="modal-content card">
        <span class="close-modal">&times;</span>
        <h2 id="modal-title">Contatta Professionista</h2>
        <div id="contact-info" class="contact-info">
            <p><strong>Telefono:</strong> <span id="modal-phone"></span></p>
            <p><strong>Email:</strong> <span id="modal-email"></span></p>
        </div>
        <hr>
        <form id="contact-form">
            <input type="hidden" id="contact-prof-id" name="prof_id">
            <div class="form-group">
                <label for="sender-name">Il tuo nome</label>
                <input type="text" id="sender-name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sender-email">La tua email</label>
                <input type="email" id="sender-email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Messaggio</label>
                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Invia Messaggio</button>
        </form>
    </div>
</div>

<?php 
$extra_js = ['search', 'modal'];
require_once __DIR__ . '/../../includes/footer.php'; 
?>
