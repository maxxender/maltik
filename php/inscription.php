<?php
session_start();
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$mdp = htmlspecialchars( password_hash($_POST['mdp'], PASSWORD_BCRYPT) );
$errors = [];
$ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if(empty($prenom) || empty($email) || empty($mdp) ){
    $errors[] = 'Tous les champs du formulaire doivent etre remplis! Veuillez réessayez';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Votre adresse mail n\'est pas valide!';
}

if(!preg_match('/[0-9]/', $_POST['mdp'])){
    $errors[] = 'Votre mot de passe doit contenir au moins 01 chiffre';
}

if(mb_strlen($_POST['mdp']) < 8){
    $errors[] = "Votre mot de passe est trop court! Il doit contenir au moins 08 caractères";
}

if(empty($errors)){
    include_once 'pdo.php';
    $req = $pdo->prepare("INSERT INTO students(nom,prenom,telephone, date_entree, mdp, email, photo) VALUES(?,?,?,NOW(),?,?, ? )");
    $req->execute(array(
        'non défini',
        $prenom,
        "non défini",
        $mdp,
        $email,
        ''
    ));
    $_SESSION['id_user'] = $pdo->lastInsertId();
    
    if($ajax){
        echo json_encode(['Inscription validé']);
        header('Content-Type: application/json');
        http_response_code(200);
        die();
    }else{
        header('location:../dashboard.php');
    }

}else{
    if($ajax){
        echo json_encode($errors);
        header('Content-Type: application/json');
        http_response_code(400);
        die();
    }else{
        header('location:../inscription.html');
    }
}