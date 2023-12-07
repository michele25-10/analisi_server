<?php
function get($file)
{
    $json_content = file_get_contents($file);

    if ($json_content === false) {
        return -1;
    }

    // Decodifica il JSON in un array associativo
    $data = json_decode($json_content, true);

    if ($data === null) {
        return -1;
    }

    return $data;
}

function getStat()
{
    $file_path = '../process/stat.json';
    return get($file_path);
}

function getProcessiPm2()
{
    $file_path = '../process/processi_pm2.json';
    return get($file_path);
}

function getPorteAttive()
{

    // Percorso del file di testo
    $file_path = '../process/porte_attive.txt';

    // Leggi il contenuto del file di testo
    $file_lines = file($file_path, FILE_IGNORE_NEW_LINES);

    if ($file_lines === false) {
        // Errore nella lettura del file
        return -1;
    }

    // Ora puoi manipolare le righe come desiderato
    return $file_lines;
}
