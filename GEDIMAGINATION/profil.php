<?php 
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gedimat','root','');

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

    $getvoteimg = $bdd->prepare('SELECT * FROM vote WHERE id_img = ?');
    $getvoteimg->execute(array($id_img));
    $voteexist = $getvoteimg->rowCount();
    $mon_vote = $getvoteimg->fetchAll();
    

    $V = 0;
    $nbvote = 0;
    $moyenne = 0;

    if ($voteexist >= 1){

        foreach($mon_vote as $vote){
            $V = $V + 1;
            $nbvote = $nbvote + $vote['vote_value'];
        }
        $moyenne = $nbvote / $V;
    }

    

   

if(isset($_POST['addimg_form'])) {
        header("Location: addimg.php?id=".$_SESSION['id']);
    }
?>



<html>
    <header>
        <title> Profil </title>
        <link rel="stylesheet" type="text/css" href="asset/css/profil.css">
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
    
        <center>

        <!-- Afficher le profil de la personne -->

        <div class="profil_personne">
            
            <div class="profil_titre">
                <h2> Profil de <?php echo $userinfo['pers_prenom']; ?> </h2>
            </div>

            <div class="profil_body_personne">
                
                    <div class="profil_div">
                        <div class="profil_entt">Nom : </div>
                        <div class="profil_desc"> <?php echo $userinfo['pers_nom']; ?></div>
                    </div>

                    <div class="profil_div">
                        <div class="profil_entt">Prénom : </div>
                        <div class="profil_desc"> <?php echo $userinfo['pers_prenom']; ?></div>
                    </div>

                    <div class="profil_div">
                       <div class="profil_entt"> Email : </div>
                       <div class="profil_desc"> <?php echo $userinfo['pers_mail']; ?> </div>
                    </div>  

                    <div class="profil_div">
                        <div class="profil_entt">Sexe : </div>
                        <div class="profil_desc"> <?php echo $userinfo['pers_sexe']; ?> </div>
                    </div>
                    
            </div>



            <!-- Si une image existe alors :  -->

            <?php if ($img_exist == 1){

                ?>
            <div>
            <div class="profil_body_img">

            <div>
                <div class=""> <img style="width:250px; height:150px;  border-radius:15%;" src="<?php echo $mon_img['img_url'] ?> "> </div>

                <div class="profil_div">
                    <div class="" style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-style:italic;" > <?php echo $mon_img['img_nom']; ?> </div>
                </div>
            </div>
            
                
                <div class="profil_div">
                    <div class="">Nombre de vote : </div>
                    <div class=""> <?php echo $nbvote; ?></div>
                </div>

                <div class="profil_div">
                    <div class="">Notes moyenne attribuée : </div>
                    <div class=""> <?php echo $moyenne;?> </div>
                </div>

            </div>
            <div>

            <!-- si aucune image alors bouton ajouter image -->

            <?php
            }else{
            ?>
            <div>
                <form action="" method="POST" class="addimg">                            
                        <input type="submit" id='submit' name="addimg_form" value="Ajouter une image" > 
                </form>
            <div>
            <?php
            }
            ?>

        </div>


<!--  BOUTON DE  VOTE ET DE STAT -->


        <div >
            <?php if($userinfo['pers_avote'] < 3){
            ?>

            <div class="profil_boutton" >
                <a href="vote.php"> <h2> Voter </h2> </a>
            </div>
            <?php
            }else{
            ?>
        
            <div class="profil_boutton_deja">
                <h2> Vous avez déja voté </h2> 
            </div>
            <?php
            }
            ?>
            
            <div class="profil_boutton">
                <a href="stat.php"><h2> Voir le premier </h2></a>
            </div>
        </div>


        </center>        
    </body>
</html>

<?php
}
?>