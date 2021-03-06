<?php
require ("common.php");

if (empty($_SESSION['user']))
    {
    header("Location: login.php");
    die("Redirecting to login.php");
    }
$row=$_SESSION['user'];
      if ($row['tipo'] != 1 )
      {
         die("Non puoi visualizzare questa pagina"); 
      }
?> 
Hello <?php
echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>, benvenuto!<br /> 

<!DOCTYPE html>
<html>
<body>

<script type="text/javascript">

function controllaNome() {
    var nome = document.getElementById("fileToUpload").value;
    var pattern = new RegExp(/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/);
    if (pattern.test(nome)) {
        alert("Il nome del file che vuoi caricare contiene caratteri speciali");
        return false;
    }
    return true;
}

</script>
<a href="memberlist.php">Memberlist</a><br /> 
<a href="edit_account.php">Edit Account</a><br /> 
<a href="user_managment.php">Gestione Utenti</a><br /> 
<a href="logout.php">Logout</a><br/>

<?php
$mestesso = htmlspecialchars($_SERVER["PHP_SELF"]);

if (!isset($_POST['upload']) && !isset($_POST['playlist']) && !isset($_POST['createfile']) && !isset($_POST['scegli_playlist']) && !isset($_POST['scegli']))
    {
    echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\">
         <h4>Seleziona il file da caricare:</h4>
                <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\"><br/><br />
                <input type=\"submit\" value=\"Carica\" name=\"upload\" onClick=\"return controllaNome()\"><br/><br/>
        <h4>Crea una Playlist</h4>
                <input type=\"submit\" value=\"Crea Playlist\" name=\"playlist\"><br/><br/>
        <h4>Scegli una Playlist</h4>
                <input type=\"submit\" value=\"Scegli Playlist\" name=\"scegli_playlist\">        
             </form>";
    }
  else
    {
    if (isset($_POST['upload']))
        {
        $target_dir = "/music/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $target_file = preg_replace('/\s+/', '_', $target_file);
        $uploadOk = 1;
        $musicFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        if (file_exists($target_file))
            {
            echo ("\nIl file esiste già.<br/><br/>");
            $uploadOk = 0;
            }

        if ($_FILES["fileToUpload"]["size"] > 100000000)
            {
            echo ("Il file è troppo grande per essere caricato (max 100MB).<br/><br/>");
            $uploadOk = 0;
            }

        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $target_file))
            {
            echo ("Il nome del file contiene caratteri speciali<br/><br/>");
            $uploadOk = 0;
            }

        if ($musicFileType != "mp3")
            {
            echo ("Puoi caricare solo file .mp3<br/><br/>");
            $uploadOk = 0;
            }

        if ($uploadOk == 0)
            {
            echo "Il file non è stato caricato.<br/><br/>";
            echo "<a href=\"playlist.php\">Torna alla home.</a>";
            }
          else
            {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
                {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " è stato caricato.";
                }
              else
                {
                echo "Spiacente, c'è stato un errore durante l'upload del tuo file.";
                }
            }
        }

    if (isset($_POST['playlist']))
        {
        $currentdir = getcwd();
        $dir_musica = "/music/";
        chdir("$dir_musica");
        $filelist = glob("*.mp3");
        if (empty($filelist))
            {
            echo "La directory è vuota..";
            }
          else
            {
            echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\">";
            echo " <h4>Scegli un nome per la tua playlist</h4>";
            echo "Nome: <input type=\"text\" name=\"nomeplay\" />";
            echo " <h4>Scegli i brani da aggiungere alla playlist</h4>";
            foreach($filelist AS $file)
                {
                if (is_file($file))
                    {
                    echo "<input type=\"checkbox\" name=\"checkfiles[]\" value=\"$file\">$file<br /><br />\n";
                    }
                }

            echo "<input type=\"submit\" value=\"Crea Playlist\" name=\"createfile\">\n</form><br />";
            }

        chdir("$currentdir");
        }

    if (isset($_POST['createfile']))
        {
        $uploadOk = 1;
        $nomeplay = $_POST['nomeplay'];
        $songs = $_POST['checkfiles'];
        if (!isset($_POST['checkfiles']))
            {
            echo "Devi scegliere i file da caricare!<br/><br/>";
            $uploadOk = 0;
            }

        if (!isset($_REQUEST['nomeplay']) || strlen(trim($_REQUEST['nomeplay'])) == 0)
            {
            echo "Devi inserire il nome del file<br /><br/>";
            $uploadOk = 0;
            }

        if ($uploadOk == 0)
            {
            echo "Il file non è stato caricato.<br/><br/>";
            echo "<a href=\"playlist.php\">Torna alla home.</a>";
            }
          else
            {
            $fh = fopen('/music/' . $nomeplay . '.m3u', 'w') or die("Impossibile caricare il file");
            foreach($_POST['checkfiles'] AS $selectedfile)
                {
                echo "/music/" . $selectedfile . "<br /><br />";
                fwrite($fh, "/music/" . $selectedfile . "\n");
                }

            fclose($fh);
            echo "Playlist Creata!<br/><br/>";
            echo "<a href=\"playlist.php\">Torna alla home.</a>";
            }
        }

    // scegli playlist

    if (isset($_POST['scegli_playlist']))
        {
        $uploadOk = 1;
        $currentdir = getcwd();
        $dir_playlist = "/music/";
        chdir("$dir_playlist");
        $filelistt = glob("*.m3u");
        if (empty($filelistt))
            {
            echo "La directory è vuota..<br/>";
            }
          else
            {
            echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\">";
            echo " <h4>Scegli la playlist che vuoi pubblicare</h4>";
            foreach($filelistt AS $file)
                {
                if (is_file($file))
                    {
                    echo "<input type=\"radio\" name=\"files[]\" value=\"$file\">$file<br /><br />\n";
                    }
                }

            echo "<input type=\"submit\" value=\"Scegli\" name=\"scegli\">\n</form><br />";
            }

        chdir("$currentdir");
        }

    if (isset($_POST['scegli']))
        {
        if (isset($_POST['files']))
            {
            foreach($_POST['files'] AS $selectedfile)
                {
                echo "Hai selezionato: " . $selectedfile . "<br/>";
                rename("/music/" . $selectedfile, "/music/playlist.m3u");
                echo "La tua playlist è stata impostata<br/><br/>";
                echo "<a href=\"playlist.php\">Torna alla home.</a>";
                }
            }
          else
            {
            echo "Devi selezionare almeno una playlist.<br/><br/>";
            echo "<a href=\"playlist.php\">Torna alla home.</a>";
            }
        }

    // fine scegli playlist

    }

?> 

</body>
</html> 
