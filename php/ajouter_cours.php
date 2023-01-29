<?php
session_start();
$titre_cours = htmlspecialchars($_POST['titre_cours']);
$description_cours = htmlspecialchars($_POST['description_cours']);
$affiche_cours = $_FILES['affiche_cours']['name'];
if(!empty($titre_cours) && !empty($description_cours) && !empty($affiche_cours)){
    include_once "pdo.php";
    $req = $pdo->prepare('INSERT INTO cours(titre_cours, description_cours, affiche_cours, id_prof, prix,horaires_dispo) VALUES(?, ?, ?, ?, ?, ?) ');
    $req->execute(array(
        $titre_cours,
        $description_cours,
        $affiche_cours,
        $_SESSION['id_user'],
        0,
        'h24'
    ));
    move_uploaded_file($_FILES['affiche_cours']['tmp_name'], "../images/affiches_cours/".$_FILES['affiche_cours']['name']);
    header('location:../dashboard.php');
}