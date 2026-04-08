# SpareCare

Sistema di matching tra professionisti dell'assistenza e utenti.

## Caratteristiche
- **Area Riservata Professionisti**: Gestione profilo, tariffe, servizi e disponibilità.
- **Ricerca Avanzata**: Filtra professionisti per città, servizio e disponibilità.
- **Contatto Diretto**: Sistema di contatto via email e visualizzazione recapiti telefonici.

## Tech Stack
- Frontend: HTML5, CSS3, Vanilla JavaScript
- Backend: PHP 7.4+
- Persistence: JSON files con file locking
- Security: Password hashing (bcrypt), input sanitization, session management

## Struttura del Progetto
```
/
├── index.html              # Homepage pubblica con ricerca
├── dashboard.html          # Dashboard professionisti
├── login.html              # Pagina di login
├── register.html           # Pagina di registrazione
├── style.css               # Foglio di stile principale
├── app.js                  # Funzioni utility JavaScript
├── auth.js                 # Gestione autenticazione
├── dashboard.js            # Funzionalità dashboard
├── search.js               # Funzionalità ricerca
├── modal.js                # Gestione modali
├── /api/                   # API backend
│   ├── common.php          # Funzioni comuni
│   ├── login.php           # Login
│   ├── logout.php          # Logout
│   ├── register.php        # Registrazione
│   ├── get-profile.php     # Ottieni profilo
│   ├── update-profile.php  # Aggiorna profilo
│   ├── upload-photo.php    # Upload foto
│   ├── list-professionals.php # Lista professionisti
│   └── send-email.php      # Invio messaggi
├── /data/                  # Dati JSON
│   └── professionals.json
├── /uploads/               # Foto profilo
└── .htaccess               # Configurazione Apache
```

## Installazione
1. Clona il repository in una cartella servita da un server web con supporto PHP.
2. Assicurati che la cartella `data/` e `uploads/` siano scrivibili dal server.
3. Il sistema è pronto all'uso.

## API Endpoints
- `POST /api/login.php` - Login utente
- `POST /api/logout.php` - Logout utente
- `POST /api/register.php` - Registrazione nuovo professionista
- `GET /api/get-profile.php` - Ottieni profilo (richiede autenticazione)
- `POST /api/update-profile.php` - Aggiorna profilo (richiede autenticazione)
- `POST /api/upload-photo.php` - Upload foto profilo (richiede autenticazione)
- `GET /api/list-professionals.php` - Lista professionisti pubblici
- `POST /api/send-email.php` - Invia messaggio a professionista
