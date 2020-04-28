<?php 
session_start();

$idpers = $_SESSION['id'];;
$bdd = new PDO('mysql:host=localhost;dbname=gedimat','root','');

if(isset($_GET['id'])){
            header("Location: profil.php?id=".$_SESSION['id']);
        }

?>