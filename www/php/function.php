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
    $data = get($file_path);

    $matches = explode('GB', $data["GB_usati"]);
    $data["GB_usati"] = (float)$matches[0];

    $matches = explode('GB', $data["GB_liberi"]);
    $data["GB_liberi"] = (float)$matches[0];

    return $data;
}

function getProcessiPm2()
{
    $file_path = '../process/processi_pm2.json';
    return get($file_path);
}

function getTxt($file)
{
    $file_lines = file($file, FILE_IGNORE_NEW_LINES);

    if ($file_lines === false) {
        // Errore nella lettura del file
        return -1;
    }

    // Ora puoi manipolare le righe come desiderato
    return $file_lines;
}

function getPorteAttive()
{
    // Percorso del file di testo
    $file_path = '../process/porte_attive.txt';
    return getTxt($file_path);
}

function getLog()
{
    // Percorso del file di testo
    $file_path = '../process/log.txt';
    $data = getTxt($file_path);

    $newData[0] = $data[0];
    $last10Data = array_slice($data, -10);
    $count = 1;
    for ($i = 0; $i < 10; $i++) {
        $newData[$count] = $last10Data[$i];
        $count++;
    }

    return $newData;
}
