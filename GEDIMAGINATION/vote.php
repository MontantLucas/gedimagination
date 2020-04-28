<?php 
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gedimat','root','');

if(isset($_SESSION['id'])){

    $getid = $_SESSION['id'];
    $req_user = $bdd->prepare('SELECT * FROM personne WHERE pers_id = ?');
    $req_user->execute(array($getid));
    $userinfo = $req_user->fetch();

    $allimg = $bdd->prepare('SELECT * FROM image WHERE id_pers <> ?');
    $allimg->execute(array($_SESSION['id']));
    $all_img = $allimg->fetchAll();
}


?>


<html>
    <header>
        <title> Profil </title>
        <link rel="stylesheet" type="text/css" href="asset/css/vote.css">
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
    <?php 


      

    foreach($all_img as $value){
    ?>

    <center style="padding-left:2%; padding-right:2%;">
        <div class="img_style">

                <div class="vote_title">
                    <h2> Nom de l'image : <?php echo $value[2];  ?></h2>               
                </div>

                <div class="vote_body">
                    <img src="<?php echo $value[1];  ?>" class="imgstyle">
                </div>
                <a href="action.php?v=1&id=<?php echo $value[0];?>"><img src="asset/img/star1" title="1" class="star" ></a>
                <a href="action.php?v=2&id=<?php echo $value[0];?>"><img src="asset/img/star1" title="2" class="star"></a>
                <a href="action.php?v=3&id=<?php echo $value[0];?>"><img src="asset/img/star1" title="3" class="star"></a>
                <a href="action.php?v=4&id=<?php echo $value[0];?>"><img src="asset/img/star1" title="4" class="star"></a>
                <a href="action.php?v=5&id=<?php echo $value[0];?>"><img src="asset/img/star1" title="5" class="star"></a>
               
        </div>
    </center>

    <?php
        }
    ?>

    </body>
</html>
