<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Analisi_server</title>
  <link rel="icon" href="https://png.pngtree.com/element_our/20200702/ourmid/pngtree-web-server-vector-icon-image_2289946.jpg" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div class="bg-dark text-center" style="height: 80px">
    <h2 class="p-3 text-white">Analisi Server</h2>
  </div>

  <div class="m-5" id="container">

  </div>

  <script>
    function aggiornaContenuto() {
      $.ajax({
        url: './php/aggiornamento.php',
        type: 'GET',
        success: function(data) {
          console.log("aggionrato");
          // Aggiorna il contenuto della pagina con il nuovo contenuto restituito dal server
          $('#container').html(data);
        },
        error: function() {
          alert('Si è verificato un errore durante l\'aggiornamento.');
        }
      });
    }
    $(window).on('load', function() {
      aggiornaContenuto()
      setInterval(() => aggiornaContenuto(), 30000);
    });
  </script>

  <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>