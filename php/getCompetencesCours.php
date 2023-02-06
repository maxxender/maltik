<?php
session_start();
if(!empty($_GET['id'])){
    include_once "pdo.php";
    $req = $pdo->prepare('SELECT * FROM competences_cours WHERE id_cours = ?');
    $req->execute(array(
        $_GET['id']
    ));
    $competences_cours = $req->fetchAll(PDO::FETCH_OBJ);
    //var_dump($competences_cours);
    echo json_encode($competences_cours);
}else{
    echo "Pas de get recu";
}