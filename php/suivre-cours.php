<?php
session_start();
if(!empty($_SESSION['id_user'])){
    if($_GET['idp'] != $_SESSION['id_user']){
        include_once 'pdo.php';

        $req = $pdo->prepare('SELECT id FROM apprentissages WHERE id_cours = ? AND id_eleve = ?');
        $req->execute(array(
            $_GET['id'],
            $_SESSION['id_user']
        ));
        $cours_deja_suivi = $datasApprentissages['id'] =  $req->fetch();
        if(!$cours_deja_suivi){
            $req = $pdo->prepare('INSERT INTO apprentissages (id_eleve, id_cours, date_debut, id_prof) VALUES(?, ?, NOW(), ?)');
            $req->execute(array(
                $_SESSION['id_user'],
                $_GET['id'],
                $_GET['idp'],
            ));
        }
        header('location:../dashboard.php?id_user='.$_SESSION['id_user']);
    }else{
        header('location:../se-formez.html');
    }
}else{
    header("location:../inscription.html");
}