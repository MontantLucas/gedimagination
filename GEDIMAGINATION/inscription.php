<?php 

$bdd = new PDO('mysql:host=localhost;dbname=gedimat','root','');
if(isset($_POST['form_valider'])){
    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['mdp']) AND !empty($_POST['sexe'])){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = sha1($_POST['mdp']);
        $sexe = $_POST['sexe'];

        $create_account = $bdd->prepare("INSERT INTO personne(pers_prenom, pers_nom, pers_mail, pers_mdp, pers_sexe) VALUES(?, ?, ?, ?, ?)");
        $create_account->execute(array($prenom,$nom,$email,$mdp,$sexe));
        $reussite = "<h3 center> Votre compte a bien été crée </h3>";
        header('Refresh:2; url="connexion.php');
        echo $reussite;
        exit();
    }
    else{
        $erreur = " tous les champs ne sont pas remplis ";
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
                <li class="img_logo"> <a href="connexion.php"><img src="asset/img/logo_gedimat"></a></li>
                <li><a href="{{tpl:BlogURL}}">Facebook</a></li>
                <li><a href="{{tpl:BlogURL}}archive" title="Liste des mois de publication">Twitter</a></li>
                <li><a href="{{tpl:BlogURL}}contact" title="Formulaire de contact">Instagram</a></li>
            </ul>
        </div>

        <div class="inscription">
            <h2> Connectez-vous pour poster vos créations </h2>

            <form action="" method="POST">

                <div class="div_inscription">
                    <label for="nom ">Nom :</label>
                    <input type="text" placeholder="Entrer votre nom" name="nom" id="nom" style="margin-left:15%;"required>
                </div>

                <div class="div_inscription">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" placeholder="Entrer votre prenom" name="prenom" style="margin-left:11%;" required>
                </div>

                <div class="div_inscription">
                    <label for="email">Adresse mail :</label>
                    <input type="text" id="email" placeholder="Entrer votre email" name="email" required>
                </div>

                <div class="div_inscription">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" id="mdp" placeholder="Entrer le mot de passe" name="mdp" required>
                </div>

                <div class="div_inscription"  style="margin-top:2%;">
                    <label>Sexe :</label>
                        <input type="radio" name="sexe" value="homme" id="homme" required>
                        <label for="homme"> Homme </label>
                        <input type="radio" name="sexe" value="femme" id="femme" required>
                        <label for="femme" style="color:#eb34b1"> Femme </label>
                </div>

                <input type="submit" name="form_valider" id='submit' value='CREER VOTRE COMPTE' >

            </form>

            <?php 
            if(!empty($erreur)){
                echo $erreur;
            }
            ?>

        </div>
    </body>
</html>