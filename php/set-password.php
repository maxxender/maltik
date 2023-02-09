<?php
session_start();
$ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$errors = [];

    if(empty($_POST['recentPass']) || empty($_POST['newPass'])){
        $errors['error_empty_field_pass'] = 'Certains champs du formulaire sont vides. Veuillez réessayez';
    }
    if($_POST['recentPass'] == $_POST['newPass']){
        
        $errors[] =  'Votre ancien Mot de Passe et votre nouveau Mot de Passe sont similaire. Veuillez les changez';
    }
    if(strlen(($_POST['newPass'])) < 8){
        $errors[] = 'Votre mot de passe est trop court! Il doit comporté au moins 08 caractères';
    }
    if(ctype_alpha($_POST['newPass'])){
        $errors[] = 'Votre Nouveau mot de passe doit contenu au moins un chiffre';
    }

    if(empty($errors)){
        include_once 'pdo.php';
        $recentPass = htmlspecialchars($_POST['recentPass']);
        $newPass = htmlspecialchars($_POST['newPass']);
        $req = $pdo->prepare('SELECT mdp FROM students WHERE id = ?');
        $req->execute(array(
            $_SESSION['id_user']
        ));
        $datas = $req->fetch();
        $hash = $datas['mdp'];
        if(password_verify($recentPass, $hash)){
            $setPass = $pdo->prepare('UPDATE students SET mdp = ? WHERE id = ?');
            $setPass->execute((array(
                password_hash($newPass, PASSWORD_BCRYPT),
                $_SESSION['id_user']
        )));

            if($ajax){
                echo json_encode(['Votre mot de passe a été mis à jour']);
                http_response_code(200);
            }else{
                header('location:./dashboard.php#set-profil');
            }

        }else{
            if($ajax){
                echo json_encode(['Votre mot de passe a été mis à jour']);
                http_response_code(400);
            }else{
    
            }
        }
    }else{

    }