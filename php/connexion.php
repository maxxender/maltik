<?php
session_start();
$erros = [];
include_once "pdo.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // on effectue un traitement spécifique pour l'ajax    
    if(empty($_POST['email']) || empty($_POST['mdp'])){
        $erros[] = 'Formulaire non remplis dans son intégralité. Réessayez et entree votre numéro et votre mot de passe';
    }else{
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars( password_hash($_POST['mdp'], PASSWORD_BCRYPT) );

        $req = $pdo->prepare('SELECT id, mdp, email FROM students WHERE email = ?');
        $req->execute(array(
            $email
        ));
        $datas = $req->fetch();
        if($datas){
            $is_membre = $datas['id'];
            $hash = $datas['mdp'];
            if( !empty($is_membre) && password_verify( htmlspecialchars($_POST['mdp']), $hash) ){
                $_SESSION['id_user'] = $datas['id'];
                $success[] = 'success';
                echo json_encode($success);
                header('Content-Type: application/json');
                http_response_code(200);
                die();
            }else{
                if($email != $datas['email']){
                    $erros[] = 'Email incorrect';
                }else if(!password_verify( htmlspecialchars($_POST['mdp']), $hash)){
                    $erros[] = 'Mot de passe incorrect';
                }
            }
            $erros[] = $hash;
        }

   
    }
    echo json_encode($erros);
    header('Content-Type: application/json');
    http_response_code(400);
    die();
}else {
    // on effectue un traitement spécifique au chargement classique
    if(empty($_POST['email']) || empty($_POST['mdp'])){
        $erros[] = 'Formulaire non remplis dans son intégralité. Réessayez et entree mail et votre mot de passe';
    }else{
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars( password_hash($_POST['mdp'], PASSWORD_BCRYPT) );

        $req = $pdo->prepare('SELECT id, mdp, email FROM students WHERE email = ?');
        $req->execute(array(
            $email
        ));
        $datas = $req->fetch();
        $is_membre = $datas['id'];
        $hash = $datas['mdp'];
        if($is_membre && password_verify( htmlspecialchars($_POST['mdp']), $hash) ){
            $_SESSION['id_user'] = $datas['id'];
            header('location:../dashboard.php');
        }else{
            header('location:../connexion.html');
        }
    }
}