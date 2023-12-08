<?php
include_once dirname(__FILE__) . '/function.php';
$stat = getStat();
$processipm2 = getProcessiPm2();
$porteattive = getPorteAttive();
$log = getLog();

$htmlString = '
<div class="row">
    <div class="col">
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
            <h5 class="p-2 text-center">Dati HW</h5>
            <ul>
                <li>' . (($stat["cpu"] > 80) ? '<p class="text-danger">Utilizzo CPU: ' . $stat["cpu"] . '%</p>' : '<p class="">Utilizzo CPU: ' . $stat["cpu"] . '%</p>') . '</li>
                <li>' . (($stat["temp_cpu"] > 50) ? '<p class="text-danger">Temperatura CPU: ' . $stat["temp_cpu"] . '°C</p>' : '<p class="">Temperatura CPU: ' . $stat["temp_cpu"] . '°C</p>') . '</li>
                <li><p>Spazio libero disco: ' . $stat["GB_liberi"] . ' GB</p></li>
                <li><p>Spazio occupato disco: ' . $stat["GB_usati"] . ' GB</p></li>
            </ul>
            <div class="progress bg-success m-2" role="progressbar" aria-label="Example with label"
                aria-valuenow="' . ($stat["GB_usati"] / $stat["GB_liberi"] * 100) . '" aria-valuemin="0"
                aria-valuemax="100">
                <div class="progress-bar bg-danger"
                    style="width: ' . ($stat["GB_usati"] / $stat["GB_liberi"] * 100) . '%">' . intval($stat["GB_usati"] / $stat["GB_liberi"] * 100) . '%</div>
            </div>
        </div>
    </div>
    <div class=\'col\'>
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
            <h5 class="p-2 text-center">PM2 list</h5>
            <ul>';

foreach ($processipm2 as $key => $value) {
    $htmlString .= '
                <li>
                    <p>' . $key . ': ';

    if ($value == "online") {
        $htmlString .= '<span class="text-success"> online</span>';
    } else {
        $htmlString .= '<span class="text-danger"> ' . $value . '</span>';
    }

    $htmlString .= '</p>
                </li>';
}

$htmlString .= '
            </ul>
        </div>
    </div>
    <div class="col">
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
            <h5 class="p-2 text-center">Porte in ascolto</h5>
            <ul>';

foreach ($porteattive as $value) {
    $htmlString .= '
                <li>
                    <p>' . $value . '</p>
                </li>';
}

$htmlString .= '
            </ul>
        </div>
    </div>
</div>

<hr>
<h2 class="text-center p-3">Log C</h2>
<div class="m-2 align-items-center bg-dark">';

foreach ($log as $value) {
    $htmlString .= '
    <p style="color:#00ff00;">' . $value . '</p>';
}

$htmlString .= '
</div>';

echo $htmlString;
