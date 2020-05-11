<?php 
session_start();

include 'bdd.php';


if(isset($_GET['id'])){

    $getid = intval($_GET['id']);
    $req_user = $bdd->prepare('SELECT * FROM personne WHERE pers_id = ?');
    $req_user->execute(array($getid));
    $userinfo = $req_user->fetch();




 if(isset($_POST['form_valider'])){
     if(!empty($_POST['nom_img']) AND !empty($_POST['url_img'])){

        $nom_img = htmlspecialchars($_POST['nom_img']);
        $url_img = htmlspecialchars($_POST['url_img']);

        $set_img = $bdd->prepare("INSERT INTO image(img_url,img_nom, id_pers) VALUES (?, ?, ?)");
        $set_img->execute(array($url_img, $nom_img,$getid));

        $reussite = "<h3 center> Votre image a été ajoutée </h3>";
        header('Refresh:2; url="profil.php?id='.$_SESSION['id']);
        echo $reussite;
        exit();
     }
 }
?>

<html>
    <header>
        <title> Ajouter une image </title>
        <link rel="stylesheet" type="text/css" href="asset/css/inscription.css">
    </header>
    <body>
    <div class="nav_bar">
            <ul id="nav-box">
                <li class="img_logo"> <a href="redirect.php?v=1&id=<?php echo $getid ?>"><img src="asset/img/logo_gedimat" style='float:left; margin-left:20px;'></a></li>
                <?php if($userinfo['pers_id'] == $_SESSION['id']){ ?>
                    <li><a href="edition.php"><img src="asset/img/edit" style="width:1.5%; cursor:pointer;   "></a></li>
                    <li><a href="deconnexion.php"><img src="asset/img/logout" style="width:1.5%; cursor:pointer;  "></a></li>
                <?php } ?>
            </ul>
        </div>          

        <div class="inscription">
            <h2> Ajouter une image </h2>

            <form action="" method="POST">

                <div class="div_inscription">
                    <label for="nom_img ">Nom de l'image :</label>
                    <input type="text" placeholder="Entrer le nom de votre image" name="nom_img" id="nom_img" style="margin-left:15%;"required>
                </div>

                <div class="div_inscription">
                    <label for="url_img">Url de l'image :</label>
                    <input type="text" id="url_img" placeholder="Entrer l'url de votre image" name="url_img" style="margin-left:11%;" required>
                </div>

                <input type="submit" name="form_valider" id='submit' value='Ajouter votre image' >

            </form>
        </div>
    </body>
</html>
                <?php } ?>