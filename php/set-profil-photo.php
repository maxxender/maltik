<?php
session_start();
if(!empty($_SESSION['id_user']) & !empty($_FILES['photo'])){
    include_once 'pdo.php';
    $req = $pdo->prepare('UPDATE students SET photo = ? WHERE id = ?');
    $req->execute((array(
        $_FILES['photo']['name'],
        $_SESSION['id_user']
    )));
    move_uploaded_file($_FILES['photo']['tmp_name'], '../images/photos_profil/'.$_FILES['photo']['name']);
}
echo json_encode($_FILES);