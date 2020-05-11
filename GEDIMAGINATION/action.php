<?php 
session_start();
include 'bdd.php';

$idpers = $_SESSION['id'];;

if(isset($_GET['id'])){
        $getid = (int) $_GET['id'];
        $getv = (int) $_GET['v'];
 
        $check = $bdd->prepare('SELECT img_id FROM image WHERE img_id = ?');
        $check->execute(array($getid));

        if($check->rowCount() == 1){
            $vote = $bdd->prepare('INSERT INTO vote(id_img, id_pers, vote_value) VALUES (?, ?, ?)');
            $vote->execute(array($getid, $idpers, $getv));

            $avote = $bdd->prepare('UPDATE personne SET pers_avote = pers_avote+1 WHERE pers_id = ?');
            $avote->execute(array($idpers));

            $veripers = $bdd->prepare('SELECT pers_avote FROM personne WHERE pers_id = ?');
            $veripers->execute(array($idpers));
            $Rep = $veripers->fetch();
        }
        if($Rep[0] < 3){
            $msg =  "<h3 center> Votre vote a été pris en compte vous pouvez voter a nouveau ! </h3>";
            header('Refresh:2; url="vote.php');
            echo $msg;
        } else {
            header("Location: profil.php?id=".$_SESSION['id']);
        }
}