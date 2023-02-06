<?php
session_start();
$titre_cours = htmlspecialchars($_POST['titre_cours']);
$description_cours = htmlspecialchars($_POST['description_cours']);
$affiche_cours = $_FILES['affiche_cours']['name'];
$duree = settype(htmlspecialchars($_POST['duree_cours']), "integer");

if(!empty($titre_cours) && !empty($description_cours) && !empty($affiche_cours)){
    include_once "pdo.php";
    $req = $pdo->prepare('INSERT INTO cours(titre_cours, description_cours, affiche_cours, id_prof, horaires_dispo, duree_cours, prix) 
                        VALUES(?, ?, ?, ?, ?, ?, ?) ');
    $req->execute(array(
        $titre_cours,
        $description_cours,
        $affiche_cours,
        $_SESSION['id_user'],
        'h24',
        $duree,
        $_POST['prix']
    ));

    $id_dernier_cours_inserer = $pdo->lastInsertId();


    move_uploaded_file($_FILES['affiche_cours']['tmp_name'], "../images/affiches_cours/".$_FILES['affiche_cours']['name']);

    foreach ($_POST as $key => $value) {
        # code...
       
        if(preg_match('#competence#', $key)){
            echo 'val : ' .$_POST[$key];
            $req1 = $pdo->prepare('INSERT INTO competences_cours(contenu,id_cours, date_ajout) VALUES(?, ?, NOW())');
            $req1->execute(array(
                htmlspecialchars($_POST[$key]),
                $id_dernier_cours_inserer
            ));
        }
    }

    header('location:../dashboard.php#cours-donnees');
}