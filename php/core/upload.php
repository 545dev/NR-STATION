<?php
if (isset($_POST['upload']))
        {
        $target_dir = "/music/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $target_file = preg_replace('/\s+/', '_', $target_file);
        $uploadOk = 1;
        $musicFileType = pathinfo($target_file, PATHINFO_EXTENSION);

         if (strlen(trim($_POST['artista'])) == 0)
            {
            echo "<div class=\"text-center alert alert-danger\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                  <i class=\"fa fa-ban-circle\"></i><strong>Attenzione!</strong> <a href=\"#\" class=\"alert-link\">campo vuoto</div>";

            $uploadOk = 0;
            }

        if (file_exists($target_file))
            {
            echo "<div class=\"text-center alert alert-danger\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                  <i class=\"fa fa-ban-circle\"></i><strong>Attenzione!</strong> <a href=\"#\" class=\"alert-link\">Il file esiste già.</div>";

            $uploadOk = 0;
            }

        if ($_FILES["fileToUpload"]["size"] > 100000000)
            {
            echo "<div class=\"text-center alert alert-danger\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                  <i class=\"fa fa-ban-circle\"></i><strong>Attenzione!</strong> <a href=\"#\" class=\"alert-link\">Il file è troppo grande (max 100mb).</div>";
                  
            $uploadOk = 0;
            }

        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $target_file))
            {
            echo "<div class=\"text-center alert alert-danger\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                  <i class=\"fa fa-ban-circle\"></i><strong>Attenzione!</strong> <a href=\"#\" class=\"alert-link\">caratteri speciali</div>";

            $uploadOk = 0;
            }

        if ($musicFileType != "mp3")
            {
            echo "<div class=\"text-center alert alert-danger\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                  <i class=\"fa fa-ban-circle\"></i><strong>Attenzione!</strong> <a href=\"#\" class=\"alert-link\">no mp3.</div>";

            $uploadOk = 0;
            }

        if ($uploadOk == 0) {}

          else
            {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
                {
                $artista = $_POST["artista"];
                $idUtente = $_SESSION['user']['id'];

                echo "<div class=\"text-center alert alert-success\">
                      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                      <i class=\"fa fa-ban-circle\"></i><strong>Success</strong> <a href=\"#\" class=\"alert-link\">Il file è stato caricato.</div>";

                $query = "
                         INSERT INTO canzoni 
                              (titolo,
                              artista,
                              idUtente)
 
                         VALUES ('$target_file',
                              '$titolo'
                              '$artista',
                              '$idUtente')";
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
              else
                {
                echo "<div class=\"text-center alert alert-danger\">
                      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                      <i class=\"fa fa-ban-circle\"></i><strong>Attenzione!</strong> <a href=\"#\" class=\"alert-link\">Si è verificato un errore durante il caricamento, prova a ricaricare la pagina.</div>";
                }
            }
        }
?>
