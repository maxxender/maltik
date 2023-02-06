<?php
session_start();
if(!empty($_GET['id'])){
    include_once "pdo.php";
    $req = $pdo->prepare('SELECT cou.id, cou.id_prof, cou.titre_cours, cou.prix, cou.description_cours, cou.affiche_cours, cou.duree_cours
        ,stu.nom, stu.prenom FROM cours cou INNER JOIN students stu ON cou.id_prof = stu.id  WHERE cou.id = ?');
    $req->execute(array(
        $_GET['id']
    ));
    $datas = $req->fetch(PDO::FETCH_OBJ);
    echo json_encode($datas);
}else{
    echo "Pas de get recu";
}