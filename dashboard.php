<?php
session_start();
if(empty($_SESSION['id_user'])){
    //var_dump($_SESSION['id_user']);
    header("location:./");
}
include_once 'php/pdo.php';
$req = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$req->execute(array($_SESSION['id_user']));
$students = $req->fetch();

$getCours = $pdo->prepare('SELECT * FROM cours WHERE id_prof = ?');
$getCours->execute(array(
        $_SESSION['id_user']
));
$cours_donnees = $getCours->fetchAll();

$getCoursSuivis = $pdo->prepare('SELECT  ap.date_debut, co.titre_cours, co.description_cours, co.affiche_cours FROM apprentissages ap INNER JOIN cours co 
ON ap.id_cours = co.id
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
    <link rel="stylesheet" href="css/style.css">
    <title>MALTIK - Services de créations de votre site web pas cher</title>
    <style>
        .contenu-panneau{
            display:none;
        }
    </style>
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
            <div class="bloc-photo">
                <img src="images/photos_profil/<?= empty($students['photo']) ? 'matinouca.png' : $students['photo'] ?>" alt="photo de profil" >
                <div><a href="">Ajouter ma photo</a></div>
            </div>
            <div class="identification identification__nom-prenom"><?= $students['nom'] .' ' .$students['prenom'] ?></div>
        </div>
        <div class="prochain_cours">
            <h4>Un cours vous attends</h4>
            <div>Votre prochain est prévu le <span class="date">02 avril 2023</span> à <span class="heure">11h</span></div>
        </div>
        <div class="panneaux">
            <div class="panneau"><a href="#set-profil">Modifier Mon Profil</a></div>
            <div class="panneau"><a href="#agenda">AGENDA DES COURS SUIVIS</a> </div>
            <div class="panneau"><a href="#cours-donnees">COURS DONNEES</a></div>
            <div class="panneau"><a href="#cours-suivis">COUS SUIVIS</a></div>
            <div class="panneau"><a href="#creez-cours">VENDRE UN COURS</a></div>
            <div class="panneau"><a href="#programme">VOTRE PROGRAMME</a> </div>
        </div>
        <div class="contents">
            <div class="alert" style="font-size: 1.7em;color:orange"></div>
            <div class="contenu-panneau" id="set-profil">
                <div class="profil_photo">
                    <label for="">Modifier Photo de Profil</label>
                    <div><img style="max-width: 200px;" src="images/photos_profil/<?= empty($students['photo']) ? 'matinouca.png' : $students['photo'] ?>" alt=""></div>
                    <form action="http://localhost/maltik/php/set-profil-photo.php" method="post" id="form-photo-profil" enctype="multipart/form-data">
                        <div class="file-button-bloc"><button>Changer photo</button><input type="file" name="photo" id="photo"> </div>
                        <button type="submit" id="set-new-photo-button">Appliquer nouvelle photo</button>
                    </form>
                </div>
                <div class="profil_pass">
                    <label for="">Modifier Mot de Passe</label>
                    <form action="http://localhost/maltik/php/set-password.php" method="post" id="formSetPassword">
                        <div><input type="password" name="recentPass" id="recentPass" placeholder="Mot de Passe Actuel"></div>
                        <div><input type="password" name="newPass" id="newPass" placeholder="Nouveau Mot de Passe"></div>
                        <button type="submit">Appliquer nouveau Mot de Passe</button>
                    </form>
                    <div class="alert alert-password-form"></div>
                </div>
            </div>
          
            <div class="contenu-panneau" id="cours-suivis">
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
            <div class="contenu-panneau" id="cours-donnees">
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

            <div class="contenu-panneau" id="creez-cours">
                <h3>Dévenez prof sur maltik en créant votre premier cours</h3>
                <form action="php/ajouter_cours.php" method="post" enctype="multipart/form-data" >
                    <div class="form-part">
                        <input type="text" id="titre_cours" name="titre_cours" placeholder="Titre du cours" >
                    </div>
                    <div class="form-part">
                        <textarea name="description_cours" id="" cols="30" rows="10" placeholder="Décrivez votre cours en quelques mots"></textarea>
                    </div>
                    <div class="competences-donnees">
                        <h4>Ajouter les compétences précises que vont acquérir votre leve à la fin de votre formation</h4>
                        <div>Il doit y avoir au moins une compétence</div>
                        <div class="competences">
                            <h5>A la fin de cette formation, vous serez capable de :</h5>
                            <div class="competence">
                                <input type="text" id="competence_0" name="competence_0" class="compétence_0"> 
                            </div>
                        </div>
                        <div><a id="link_add_competence" href="" class="add">Ajouter une autre compétence</a></div>                   
                    </div>
                    <div class="duree">
                        <label for="">Durée du cours (en heures)</label>
                        <select name="duree_cours" id="duree_cours">
                            <option value="1">1 heure</option>
                            <option value="2">2 heures</option>
                            <option value="5">5 heures</option>
                            <option value="10">10 heures</option>
                            <option value="15">15 heures</option>
                            <option value="20">20  heures</option>
                            <option value="25">25 heures</option>
                            <option value="30">30 heures</option>
                        </select>
                    </div>
                    <div class="form-part">
                        <label for="">FIXER LE PRIX DE VOTRE COACHING</label>
                        <select name="prix" id="prix">
                            <option value="5000">5 000 fcfa</option>
                            <option value="10000">10 000 fcfa</option>
                            <option value="15000">15 000 fcfa</option>
                            <option value="20000">20 000 fcfa</option>
                            <option value="25000">25 000 fcfa</option>
                            <option value="30000">30 000 fcfa</option>
                        </select>
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
    <script src="http://localhost/maltik/js/competence.js" async=""></script>
    <script src="http://localhost/maltik/js/pan-dashboard.js" async=""></script>
    <script src="js/file-button-bloc.js"></script>
    <script src="http://localhost/maltik/js/set-password.js"></script>
    <script async>
        const urlParams = window.location.search;
        console.log(urlParams)
        if(window.location.hash){
            const params = new URLSearchParams(urlParams);
            document.querySelector(window.location.hash).style.display = 'inline-block'
        }
       

        
        var inputModifPhotoProfil = document.querySelector('.file-button-bloc input');
        var eleImgPhotoProfil = document.querySelector('.profil_photo img');
        var formProfilPhoto = document.querySelector('#form-photo-profil');

        inputModifPhotoProfil.addEventListener('change',function(e){
            eleImgPhotoProfil.src = window.URL.createObjectURL(this.files[0]);
            
                formProfilPhoto.addEventListener('submit',function(e){
                e.preventDefault()
                var xhr = new XMLHttpRequest()
                var formdata = new FormData(document.querySelector('#form-photo-profil'))
                xhr.onreadystatechange = function(e){
                    if(xhr.readyState === 4){
                        if(xhr.status === 200){
                            console.log(JSON.parse(xhr.responseText))
                            var divAlert = document.querySelector('.alert');
                            divAlert.innerHTML = 'Votre photo de profil a été mis à jour';
                            setTimeout(() => {
                                divAlert.innerHTML = '';
                            }, 3000);
                        }
                        else{
                            console.log('error 200')
                        }
                    }else{
                        console.log('error 4')
                    }
                }
                xhr.open('POST','http://localhost/maltik/php/set-profil-photo.php',true);
                xhr.send(formdata);

            })
        });
    </script>

</body>
</html>