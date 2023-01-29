<?php
session_start();
//$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$mdp = htmlspecialchars( password_hash($_POST['mdp'], PASSWORD_BCRYPT) );
$errors = [];
include "pdo.php";
if($mdp && $prenom && $email ){
    $req = $pdo->prepare("INSERT INTO students(nom,prenom,telephone, date_entree, mdp, email) VALUES(?,?,?, NOW(),?, ? )");
    var_dump($req);
    $r = $req->execute(array(
        'non défini',
        $prenom,
        "non défini",
        $mdp,
        $email
    ));
    echo $pdo->lastInsertId();
    $_SESSION['id_user'] = $pdo->lastInsertId();
    var_dump($_SESSION['id_user']);
    header('location:../dashboard.php');
}else{
    $errors[] = "Formulaire non completez";
    header("location:../inscription.html");
}