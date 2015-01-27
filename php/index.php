<?php
require ("common.php");

if (empty($_SESSION['user']))
    {
    header("Location: login.php");
    die("Redirecting to login.php");
    }

?> 
Benvenuto <?php
echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?> !<br /> 

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

<a href="edit_account.php">Modifica Account</a><br /> 
<a href="logout.php">Logout</a><br/>

<?php
$mestesso = htmlspecialchars($_SERVER["PHP_SELF"]);

if (!isset($_POST['playlist']) && !isset($_POST['createfile']))
    {
        echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\">
        <h4>Proponi la tua playlist</h4>
        <input type=\"submit\" value=\"Crea Playlist\" name=\"playlist\"><br/><br/> </form>";
    }
  else
    {

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

    }

?> 

</body>
</html> 
