<?php
session_start();

include 'bdd.php';

if(isset($_SESSION['id'])){

    $getid = $_SESSION['id'];

    $req_user = $bdd->prepare('SELECT * FROM personne WHERE pers_id = ?');
    $req_user->execute(array($getid));
    $userinfo = $req_user->fetch();

    $classement = $bdd->prepare('SELECT id_img, SUM(vote_value) AS tot FROM vote GROUP BY id_img ORDER BY tot DESC');
    $classement->execute();
    $resultat = $classement->fetchAll();

    $i = 0;

    ?>

<html>
    <header>
        <title> Inscription </title>
        <link rel="stylesheet" type="text/css" href="asset/css/stat.css">
    </header>
    <body>

    <div class="nav_bar">
        <ul id="nav-box">
            <li class="img_logo"> <a href="redirect.php?v=1&id=<?php echo $getid ?>"><img src="asset/img/logo_gedimat" style='float:left; margin-left:20px;'></a></li>

            <?php if($userinfo['pers_id'] == $_SESSION['id']){ ?>
                <li style="margin-right:3px;">Bonjour, <?php echo $userinfo['pers_prenom']; ?> !</li>
                <li><a href="edition.php"><img src="asset/img/edit" style="width:1.5%; cursor:pointer;   "></a></li>
                <li><a href="deconnexion.php"><img src="asset/img/logout" style="width:1.5%; cursor:pointer;  "></a></li>             
            <?php } ?>            
        </ul>
    </div>   

    <div>
        <a href="stat.php"><input type="submit" value="VOIR LE PREMIER"></a>
        <a href="stat5.php"><input type="submit" value="TOP 5"></a>
        <a  href="redirect.php?v=1&id=<?php echo $getid ?>"><input name="form_connect" value="MON PROFIL" type="submit"></a>
  
    </div>

    <?php
    while($i < 3){
        foreach($resultat as $r){
            if($i<3){
        
                $req_img = $bdd->prepare('SELECT * FROM image WHERE img_id = ?');
                $req_img->execute(array($r[0]));
                $mon_img = $req_img->fetch();

            ?>


        <center style="padding-left:2%; padding-right:2%;">
            <div class="img_style">

            <div class="place_vote">
                    <br><br>
                    <h4> Position : </h4> <h4> <?php echo $i+1; ?> </h4>
                </div>

                <div class="nb_vote">
                    <br><br>
                    <h2> Nombre de votes : </h2> <h3> <?php echo $r[1] ?> </h3>
                </div>

                <div class="vote_title">
                    <br><br>
                    <h2> Nom de l'image :</h2> <h3>  <?php echo $mon_img['img_nom']   ?></h3>               
                </div>



                <div class="vote_body">
                    <img src="<?php echo $mon_img['img_url'];  ?>" class="imgstyle">
                </div>
            </div>
            
            <?php
            $i = $i + 1;
        }
    }
}

?>
        </center>

    </body>
</html>




<?php
}
?>