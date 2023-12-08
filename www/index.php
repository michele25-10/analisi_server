<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Analisi_server</title>
  <link rel="icon" href="https://png.pngtree.com/element_our/20200702/ourmid/pngtree-web-server-vector-icon-image_2289946.jpg" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <div class="bg-dark text-center" style="height: 80px">
    <h2 class="p-3 text-white">Analisi Server</h2>
  </div>
  <?php
  include_once dirname(__FILE__) . '/../php/function.php';
  $stat = getStat();
  $processipm2 = getProcessiPm2();
  $porteattive = getPorteAttive();
  $log = getLog();
  ?>
  <div class=" m-5 ">
    <div class="row">
      <div class="col">
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
          <h5 class="p-2 text-center">Dati HW</h5>
          <ul>
            <li> <?php
                  if ($stat["cpu"] > 80) {
                    echo '<p class="text-danger">Utilizzo CPU: ' . $stat["cpu"] . "%</p>";
                  } else {
                    echo '<p class="">Utilizzo CPU: ' . $stat["cpu"] . "%</p>";
                  }
                  ?>
            </li>
            <li> <?php
                  if ($stat["temp_cpu"] > 50) {
                    echo '<p class="text-danger">Temperatura CPU: ' . $stat["temp_cpu"] . "°C</p>";
                  } else {
                    echo '<p class="">Temperatura CPU: ' . $stat["temp_cpu"] . "°C</p>";
                  }
                  ?>
            </li>
            <li><?php echo '<p>Spazio libero disco: ' . $stat["GB_liberi"] . " GB</p>"; ?>
            </li>
            </li>
            <li><?php echo '<p>Spazio occupato disco: ' . $stat["GB_usati"] . " GB</p>"; ?>
            </li>
          </ul>
          <div class="progress bg-success m-2" role="progressbar" aria-label="Example with label" aria-valuenow="<?php echo $stat["GB_usati"] / $stat["GB_liberi"] * 100 ?>" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-danger" style="width: <?php echo $stat["GB_usati"] / $stat["GB_liberi"] * 100 ?>%">
              <?php echo intval($stat["GB_usati"] / $stat["GB_liberi"] * 100) ?>%</div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
          <h5 class="p-2 text-center">PM2 list</h5>
          <ul>
            <?php foreach ($processipm2 as $key => $value) : ?>
              <li>
                <p><?php echo $key . ":" ?>
                  <?php if ($value == "online") : ?>
                    <span class="text-success"> online</span>
                  <?php else : ?>
                    <span class="text-danger"> <?php echo $value ?></span>
                  <?php endif ?>
                </p>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
          <h5 class="p-2 text-center">Porte in ascolto</h5>
          <ul>
            <?php foreach ($porteattive as $value) : ?>
              <li>
                <p><?php echo $value ?></p>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
    </div>

    <hr>
    <h2 class="text-center p-3">Log C</h2>
    <div class="m-2 align-items-center bg-dark">
      <?php foreach ($log as $value) : ?>
        <p style="color:#00ff00;"><?php echo $value ?></p>
      <?php endforeach ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>