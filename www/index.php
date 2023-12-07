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
  ?>
  <div class="container m-5">
    <div class="row">
      <div class="col">
        <div class="container" style="border-radius: 10%; border: 2px solid #000">
          <ul>
            <li>
              <p></p>
            </li>
          </ul>
        </div>
      </div>
      <div class="col">Column</div>
      <div class="col">Column</div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>