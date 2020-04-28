<html>
    <body>
        <?php
            $servername = 'localhost';
            $dbname = 'gedimat';
            $username = 'root';
            $password = '   ';
            
            //On établit la connexion
            $db = mysqli_connect($servername, $username, $password);
            mysqli_select_db($db, $dbname);
            
            //On vérifie la connexion
            if($conn->connect_error){
                die('Erreur : ' .$conn->connect_error);
            }
            echo 'Connexion réussie';
        ?>
    </body>
</html>
