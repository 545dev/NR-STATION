<!DOCTYPE html>
<html>
<body>

<?php
require ("common.php");

if (empty($_SESSION['user']))
  {
    header("Location: login.php");
    die("Redirecting to login.php");
  }

// Funzione dedicata alla cancellazione della playlist utente

function delete_playlist()
  {
    if (isset($_POST['delete_play']))
      {

        // cancella playlist

        echo "Playlist Eliminata (non è vero)";
      }
  }

if (isset($_GET['delete_playlist']))
  {
    echo "Vuoi davvero cancellare la tua playlist? <br/>";
    echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\">
          <input type=\"submit\" value=\"Cancella Playlist\" name=\"delete_play\"><br/><br/> 
          </form>";
    delete_playlist();
  }

// Funzione dedicata alla modifica della playlist utente

function modifica_playlist()
  {
  }

if (isset($_GET['modifica_playlist']))
  {
    modifica_playlist();
  }

?>
</body>
</html>