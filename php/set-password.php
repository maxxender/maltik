<?php
session_start();

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $error = [];
    if(empty($_POST['recentPass']) || empty($_POST['newPass'])){
        $error['error_empty_field_pass'] = 'Formulaire non remplis dans son intégralité';
        echo json_encode($error);
    }
    if($_POST['recentPass'] == $_POST['newPass']){
        
        $error['error_set_pass'] =  'Mot de passe Nouveau et ancien fifférent. Réessayez';
        echo json_encode($error);
    }
    include_once 'pdo.php';
    $recentPass = htmlspecialchars($_POST['recentPass']);
    $newPass = htmlspecialchars($_POST['newPass']);
    
    $req = $pdo->prepare('SELECT mdp FROM students WHERE id = ?');
    $req->execute(array(
        $_SESSION['id_user']
    ));
    $hash = $datas['mdp'] = $req->fetch();
    if(password_verify($recentPass, $hash)){
        $setPass = $pdo->prepare('UPDATE students SET mdp = ? WHERE id = ?');
        $setPass->execute((array(
            password_hash($newPass, PASSWORD_BCRYPT),
            $_SESSION['id_user']
        )));
    }
}else{
    echo "pas de javascript";
}