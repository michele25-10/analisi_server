# Analisi_Server

Analisi_Server è un progetto web dinamico che consente di monitorare lo stato del nostro server.

Momentaneamente il mio server gira su rete locale di conseguenza la pagina web che mostra i dati non necessita di un login; resta però da implementare nel caso futuro di installazione su macchine virtuali esposte in internet.
Il sito funzionerà solo su macchine linux da momento che lo script di C lavora su directory delle distribuzioni linux e non windows.

# Come avviare il progetto

La prima necessità è quella di far partire il file eseguibile nella cartella _/process/hardware_ attraverso il seguente comando:

```cmd
cd www/process/script
sudo make
sudo ../hardware & > numero_processo.txt
```

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

Installare nginx:

```cmd
sudo apt-get install php-fpm
sudo apt-get install nginx
systemctl status nginx
systemctl enable nginx
```

La configurazione è la seguente, questo file andrà inserito in _/etc/nginx/sites-available/analisi_server_:

```nginx
server {
        listen 80;  # Porta su cui il server ascolta le richieste HTTP

        # Configurazioni aggiuntive, ad esempio:
        root /home/sito/www;
        index index.html;  # Pagina di default

        location / {
            try_files $uri $uri/ =404;
        }
}

# server {
#         listen 443 ssl;
#         root /home/sito/www;
#         index index.html;

#         ssl_certificate /etc/nginx/ssl/certificate.crt;
#         ssl_certificate_key /etc/nginx/ssl/private.key;

#         location / {
#                 try_files $uri $uri/ =404;
#         }

#}

```

Ricordati di modificare i permessi della directory indicata nella root attraverso i seguenti comandi:

```cmd
chmod -R o+rx /home/sito/
sudo chmod -R o+rx /run/php

```

Il seguente file dopo essere stato creato andrà effettuato un link del file _/etc/nginx/sites-available/analisi_server_ in _/etc/nginx/sites-enable/analisi_server_

```cmd
ln -s /etc/nginx/sites-available/analisi_server /etc/nginx/sites-enabled
```

Elimina in enable il link default per non creare conflitti durante l'esposizione.

Infine rilancia il servizio per visualizzare le modifiche online:

```cmd
sudo systemctl reload nginx
```

# Script per lanciare il servizio
Crea un file contente questo pezzo di codice ovviamente modifica il percorso della directory con il percorso adeguato al tuo ambiente.

Il file dovra essere di estensione ".sh", dopo aver salvato il file esegui il seguente comando per dare i permessi di esecuzione:

```cmd
sudo chmod +x nome_file.sh
sudo ./nome_file.sh
```

```sh
#!/bin/bash
echo "script iniziato"

#Percorso della directory contente il processo
percorso="/home/sito/www/process/"

cd "$percorso" || { echo "Errore nel cambio directory."; exit 1; }

rm log.txt

#Eseguo il processo in background
./hardware &

#riavvio nginx
systemctl reload nginx

echo "script terminato"
```
