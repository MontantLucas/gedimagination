<?php 
session_start();

include 'bdd.php';

if(isset($_POST['form_connect'])){
    
    $email = htmlspecialchars($_POST['email']);
    $mdp = sha1($_POST['mdp']);

    if(!empty($email) AND !empty($mdp)){
        $req_user = $bdd->prepare("SELECT * FROM personne WHERE pers_mail = ? AND pers_mdp = ?");
        $req_user->execute(array($email,$mdp));
        $userexist = $req_user->rowCount();
        if ($userexist != 1){
            $error = "Mauvais mail ou mot de passe .";
        } else {
            $user_info = $req_user->fetch();
            $_SESSION['id'] = $user_info['pers_id'];
            $_SESSION['prenom'] = $user_info['pers_prenom'];
            $_SESSION['sexe'] = $user_info['sexe'];
            header("Location: profil.php?id=".$_SESSION['id']);
        }
    }
    else {
        $error = "Les champs doivent etre complétés";
    }
}
 
?>

<html>
    <header>
        <title> Connexion </title>
        <link rel="stylesheet" type="text/css" href="asset/css/main.css">
    </header>

    <body>
        <div class="nav_bar">
            <ul id="nav-box">
                <li class="img_logo"> <a href="connexion.php"><img src="asset/img/logo_gedimat"></a></li>
                <li><a href="{{tpl:BlogURL}}">Facebook</a></li>
                <li><a href="{{tpl:BlogURL}}archive" title="">Twitter</a></li>
                <li><a href="{{tpl:BlogURL}}contact" title="">Instagram</a></li>
            </ul>
        </div>
        <div class="expliquation">
            <h2> Gedimat organise le jeu Gedimagination</h2>
            <p> Les clients pourront mettre en ligne une photo de leur réalisation effectuée grace à leurs achats chez Gedimat </p>
            <p>Chaque personne ayant fait un achat dans le magasin Gedimat pourra voter pour sa photo préférée.</p>
            <p> Le gagnant sera divulgué le 15 Août 2020 </p>
        </div>
        <div class="connexion">
            <h2> Connectez-vous pour poster vos créations </h2>

            <form action="" method="POST">
                
                <label>Adresse Mail</label>
                <input type="text" placeholder="Entrez votre email" name="email" required>

                <label>Mot de passe</label>
                <input type="password" placeholder="Entrez votre mot de passe" name="mdp" required>

                <input type="submit" id='submit' name="form_connect" value='CONNEXION' >

            </form>
            <h2> Je n'ai pas de compte : <h2>
            <a href="inscription.php"><button > Nouveau compte </button></a>
        </div>
    </dody>


</html>