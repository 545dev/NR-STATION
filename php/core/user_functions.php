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

// Cancella Playlist

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

// Modifica Playlist

function modifica_playlist()
  {
      
  }

if (isset($_GET['edit_playlist']))
  {

    modifica_playlist();

  }

// List delle playlist utente

function play_list()
  {
    if (isset($_POST['play_list']))
      {
        // list
        $idUtente = $_SESSION['user']['id'];
        $query = "SELECT nome FROM playlist WHERE idUtente = $idUtente";

        echo "Ecco la tue playlist";
        try
            {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            }
        catch(PDOException $ex)
            {
            die("Failed to run query: " . $ex->getMessage());
            }
      }
  }

if (isset($_GET['play_list']))
  {
    
    play_list();

  }
?>
</body>
</html>
