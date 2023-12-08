# Analisi_Server

Analisi_Server è un progetto web dinamico che consente di monitorare lo stato del nostro server.

Momentaneamente il mio server gira su rete locale di conseguenza la pagina web che mostra i dati non necessita di un login; resta però da implementare nel caso futuro di installazione su macchine virtuali esposte in internet.

# Come avviare il progetto

La prima necessità è quella di far partire il file eseguibile nella cartella _/process/hardware_ attraverso il seguente comando:

Seguentemente aprendo il file nella cartella _www/index.html_ sarà possibile visualizzare la pagina che mostra i dati.

# Script di C

Lo script di C estrapola i seguenti dati:

- percentuale utilizzo CPU;
- temperatura CPU;
- GB del disco usati;
- GB del disco liberi;
- Porte attive in ascolto del server con indirizzi ip;
- Processi pm2 con il loro status.

Nel file stat.json saranno presenti le seguenti informazioni:

- percentuale utilizzo CPU;
- temperatura CPU;
- GB del disco usati;
- GB del disco liberi;

Nel file porte_attive.txt saranno presenti le seguenti informazioni:

- Porte attive in ascolto del server con indirizzi ip;

Nel file processi_pm2.json saranno presenti le seguenti informazioni:

- Processi pm2 con il loro status.

# Script javascript

La pagina index.html richiamerà ogni 30 secondi una chiamata API al file _/php/aggiornamento.php_

# Script PHP

Lo script _aggiornamento.php_ restituirà un body della pagina html e richiamerà le funzioni nello script _function.php_ che permettono di estrapolare i dati dai file costruiti dallo script di C.

# Nginx

Il sito sarà esposto attraverso nginx, per le sue egregie prestazioni in termini di esposizione di sevizi web.

La configurazione è la seguente, questo file andrà inserito in _/etc/nginx/sites-available/analisi_server_:

Ricordati di modificare i permessi della directory indicata nella root attraverso i seguenti comandi:

Il seguente file dopo essere stato creato andrà effettuato un link del file _/etc/nginx/sites-available/analisi_server_ in _/etc/nginx/sites-enable/analisi_server_

Elimina in enable il link default per non creare conflitti durante l'esposizione.
