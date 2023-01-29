<?php
include_once('pdo.php');
$req = $pdo->query("SELECT * FROM cours");
$allCours = $req->fetchAll(PDO::FETCH_OBJ);
echo json_encode($allCours);
