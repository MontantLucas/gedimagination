<?php 
session_start();

include 'bdd.php';

if(isset($_SESSION['id'])){
    $getid = intval($_GET['id']);
    $req_user = $bdd->prepare('SELECT * FROM personne WHERE pers_id = ?');
    $req_user->execute(array($getid));
    $userinfo = $req_user->fetch();

    $imgexist = $bdd->prepare('SELECT * FROM image WHERE id_pers = ?');
    $imgexist->execute(array($getid));
    $img_exist = $imgexist->rowCount();
    $mon_img = $imgexist->fetch();

    $id_img = $mon_img['img_id'];
    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email'])){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);

        $edit_account = $bdd->prepare("UPDATE personne SET pers_prenom = ? , pers_nom = ? , pers_mail = ? WHERE pers_id = ? ");
        $edit_account->execute(array($prenom,$nom,$email,$getid));
        header("Location: profil.php?id=".$_SESSION['id']);
    }

}
?>

<html>
    <header>
        <title> Inscription </title>
        <link rel="stylesheet" type="text/css" href="asset/css/inscription.css">
    </header>
    <body>
    <div class="nav_bar">
            <ul id="nav-box">
                <li class="img_logo"> <a href="redirect.php?v=1&id=<?php echo $getid ?>"><img src="asset/img/logo_gedimat"></a></li>
                <?php if($userinfo['pers_id'] == $_SESSION['id']){ ?>
                    <li style="margin-right:3px;">Bonjour, <?php echo $userinfo['pers_prenom']; ?> !</li>
                    <li><a href="editaction.php?id=<?php echo $getid ?>"><img src="asset/img/edit" style="width:1.5%; cursor:pointer;   "></a></li>
                    <li><a href="deconnexion.php"><img src="asset/img/logout" style="width:1.5%; cursor:pointer;  "></a></li>
              
                <?php } ?>
            </ul>
        </div>   

        <div class="inscription">
            <h2> Modifiez vos informations</h2>

            <form action="" method="POST" class="formaction">

                <div class="div_inscription">
                    <label for="nom ">Nom :</label>
                    <input type="text" placeholder="<?php echo $userinfo['pers_nom']  ?>" name="nom" id="nom" style="margin-left:15%;"required>
                </div>

                <div class="div_inscription">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" placeholder="<?php echo $userinfo['pers_prenom']  ?>" name="prenom" style="margin-left:11%;" required>
                </div>

                <div class="div_inscription">
                    <label for="email">Adresse mail :</label>
                    <input type="text" id="email" placeholder="<?php echo $userinfo['pers_mail']  ?>" name="email" required>
                </div>  

                <input type="submit" name="form_valider" id='submit' value='MODIFIER VOTRE COMPTE' >

            </form>

        <?php if ( $img_exist >= 1){
        ?>
        <?php
        } ?>

        </div>
    </body>
</html>