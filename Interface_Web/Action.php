<?php
 require('./assets/fonctions/Fonctions.php');
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion Ansible</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/more.css">
</head>

    <body>
        <div style="text-align: center;"> 
            <div class="app-main__inner">
                <div class="app-page-title">
                    <h3>Ajout d'une Action pour les Playbooks</h3>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="text-center">
                            <form id="form2" method="post">
                                <h5 class="card-title">Créer une Action :</h5>
                                    <div role="group" class="checkbox-wrapper-13">
                                        <label for='ActionName'>Nom de l'Action</label>
                                        <input type="text" id="ActionName" name="ActionName">
                                        <button type="submit" form="form2" name="SubmitAction" class="btn btn-primary">Ajouter</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./assets/js/main.js"></script>
        <?php
        // On vérifie que le bouton "SubmitAction" a été coché
        if (isset($_POST['SubmitAction'])) {
            Add_Action($_POST['ActionName']);
        }?>
    </body>
</html>