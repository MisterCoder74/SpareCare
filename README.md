# SpareCare

Sistema di matching tra professionisti dell'assistenza e utenti.

## Caratteristiche
- **Area Riservata Professionisti**: Gestione profilo, tariffe, servizi e disponibilità.
- **Ricerca Avanzata**: Filtra professionisti per città, servizio e disponibilità.
- **Contatto Diretto**: Sistema di contatto via email e visualizzazione recapiti telefonici.

## Tech Stack
- Frontend: HTML5, CSS3 (BEM), Vanilla JavaScript
- Backend: PHP 7.4+
- Persistence: JSON files con file locking
- Security: Password hashing (bcrypt), CSRF protection, input sanitization

## Installazione
1. Clona il repository in una cartella servita da un server web con supporto PHP.
2. Assicurati che la cartella `data/` e `assets/images/uploads/` siano scrivibili dal server.
3. Il sistema è pronto all'uso.
