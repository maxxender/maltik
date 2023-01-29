<?php
session_start();
include_once 'php/pdo.php';
$req = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$req->execute(array($_SESSION['id_user']));
$students = $req->fetch();

$getCours = $pdo->prepare('SELECT * FROM cours WHERE id_prof = ?');
$getCours->execute(array(
        $_SESSION['id_user']
));
$cours_donnees = $getCours->fetchAll();

$getCoursSuivis = $pdo->prepare('SELECT  ap.date_debut, co.titre_cours, co.description_cours, co.affiche_cours FROM apprentissages ap INNER JOIN cours co ON ap.id_cours = co.id
  WHERE id_eleve = ?');
$getCoursSuivis->execute(array(
                    $_SESSION['id_user']
));
$cours_suivis = $getCoursSuivis->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALTIK - Services de créations de votre site web pas cher</title>
</head>
<body>
    <header>
        <h1>MALTIK</h1>
        <nav>
            <a href="./">ACCUEIL</a>
            <a href="connexion.html">CONNEXION</a>
            <a href="commandez-site.html">COMMANDEZ SITE WEB</a>
            <a href="se-formez.html">SE FORMEZ</a>
            <a href="devenir-prof.html">DEVENIR PROF</a>
        </nav>
    </header>
    <div class="dashboard">
        <div class="identification">
            <img src="images/matinou.jpg" alt="" >
            <div class="identification identification__nom-prenom"><?= $students['nom'] .' ' .$students['prenom'] ?></div>
        </div>
        <div class="prochain_cours">
            <h4>Un cours vous attends</h4>
            <div>Votre prochain est prévu le <span class="date">02 avril 2023</span> à <span class="heure">11h</span></div>
        </div>
        <div class="panneaux">
            <div class="panneau">AGENDA DES COURS</div>
            <div class="panneau">COURS DONNEES</div>
            <div>COURS SUIVIS</div>
            <div class="panneau">MON ABONNEMENT</div>
            <div>DEVENIR PROF</div>
        </div>
        <div class="contents">
            <div class="agenda_prof">
                <h3>Ajouter vos céneaux horaires libres pour pouvoir dispenser ce cours</h3>
                <form action="" method="post">
                    <div class="form-part">
                        <label for="Ajouter "></label>
                        <input type="date" name="" id="">
                    </div>
                </form>
            </div>
            <div class="cours_donnees">
                <h3>La liste des cours que vous suivez</h3>
                <div class="cours">
                
                    <div class="cours__infos">
                        <?php if(empty($cours_suivis)): ?>
                            <div style="color:red;" >Vous ne suivez aucun apprentissage pour l'instant</div>
                        <?php else: ?>
                            <div class="cours__titre">
                                <div>TITRE DU COURS</div>
                                <div>DESCRIPTION DU COURS</div>
                                <div>NOMBRES D'ELEVES</div>
                            </div>
                            <?php foreach($cours_suivis as $le_cours): ?>
                                <div><?=  $le_cours['titre_cours'] ?></div>
                                <div><?=  $le_cours["description_cours"] ?></div>
                                <div><img style="max-width:150px;" src="images/affiches_cours/<?= $le_cours['affiche_cours']; ?>" alt=""></div>
                            <?php endforeach ?>
                        <?php endif ?>
                    
                    </div>
                   
                </div>
            </div>
            <div class="cours_donnees">
                <h3>La liste des cours que vous données</h3>
                <div class="cours">
                
                    <div class="cours__infos">
                        <?php if(empty($cours_donnees)): ?>
                            <div style="color:red;" >Vous ne donnez aucun cours pour l'instant</div>
                        <?php else: ?>
                            <div class="cours__titre">
                                <div>TITRE DU COURS</div>
                                <div>DESCRIPTION DU COURS</div>
                                <div>NOMBRES D'ELEVES</div>
                            </div>
                            <?php foreach($cours_donnees as $le_cours): ?>
                                <div><?=  $le_cours['titre_cours'] ?></div>
                                <div><?=  $le_cours['description_cours'] ?></div>
                                <div><img style="max-width:150px;" src="images/affiches_cours/<?= $le_cours['affiche_cours']; ?>" alt=""></div>
                            <?php endforeach ?>
                        <?php endif ?>
                    
                    </div>
                   
                </div>
            </div>

            <div class="devenir-prof">
                <h3>Dévenez prof sur maltik en créant votre premier cours</h3>
                <form action="php/ajouter_cours.php" method="post" enctype="multipart/form-data" >
                    <div class="form-part">
                        <input type="text" id="titre_cours" name="titre_cours" placeholder="Titre du cours" >
                    </div>
                    <div class="form-part">
                        <textarea name="description_cours" id="" cols="30" rows="10" placeholder="Décrivez votre cours en quelques mots"></textarea>
                    </div>
                    <div class="form-part">
                        <input type="file" name="affiche_cours" id="affiche_cours">
                        <label for="">Ajouter une image pour votre cours</label>
                    </div>
                    <button type="submit">Créez le cours</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <div><a href="./php/deconnexion.php">Déconnexion</a></div>
    </footer>
</body>
</html>