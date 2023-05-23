<?php
 require('./assets/fonctions/Fonctions.php');

$Actions = Get_Action();
$OSList = Get_OS();
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
                    <h3>Ajout d'une Commande pour les Playbooks</h3>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="text-center">
                            <form id="form1" method="post">
                                <h5 class="card-title">Créer une Commande :</h5>
                                <div role="group" class="checkbox-wrapper-13">
                                    <label for="Actions">Choisissez une Action :</label>
                                    <select name="Actions" id="Actions">
                                    <option value="">-- Sélectionner une Action --</option>
                                    <?php
                                    try {
                                        foreach ($Actions as $Action) {
                                            // Boutton radio 1
                                            echo "<option value='$Action[ID]'>$Action[Action]</option>";}
                                    } catch(Exception $e) {
                                        die('Erreur : '.$e->getMessage());
                                    }?>
                                    </select>
                                    <label for='LibelleCMD'>Nom de la Commande :</label>
                                    <input type="text" id="LibelleCMD" name="LibelleCMD">
                                </div>
                                <div role="group" class="btn-group-lg btn-group">
                                    <button type="submit" name="next" class="btn btn-primary">Suivant</button>
                                </div>
                                <div role="group" class="checkbox-wrapper-13">
                                    <div class="divider"></div>
                                        <label for="OS">Choisissez un OS :</label>
                                        <div>
                                        <?php
                                            try {
                                                foreach ($OSList as $OS) {
                                                    echo "<div>";
                                                    echo "<input type='checkbox' id='$OS[ID]' name='os$OS[ID]' value='$OS[ID]'";
                                                    if(isset($_POST['Submit'])) {
                                                        if(isset($_POST["os$OS[ID]"]) AND $_POST["os$OS[ID]"] == "$OS[ID]"){
                                                            echo" checked";
                                                        }
                                                    }
                                                    echo">";
                                                    echo "<label for='$OS[ID]'>$OS[Name]</label>";
                                                    echo "<label for='Action$OS[Name]'>Commande à effectuer :</label>";
                                                    echo "<input type='text' id='$OS[ID]' name='$OS[ID]'>";
                                                    echo "</div>";}
                                            } catch(Exception $e) {
                                                die('Erreur : '.$e->getMessage());
                                            }?>
                                        </div>
                                </div>
                            <div role="group" class="btn-group-lg btn-group">
                                <button type="submit" form="form1" name="SubmitCMD" class="btn btn-primary">Enregistrer</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./assets/js/main.js"></script>
        <?php
            try {
                // On vérifie que le bouton "SubmitCMD" a été coché
                if (isset($_POST['SubmitCMD'])) {
                    $IDAction = $_POST['Actions'];
                    $LibelleCMD = $_POST['LibelleCMD'];
                    Add_Command($IDAction, $LibelleCMD);
                    $CommandID = Get_CommandID($LibelleCMD);
                    foreach ($OSList as $OS) {
                        // On vérifie que la variable existe et on vérifie que la case à bien été cochée pour les OS
                        if (isset($_POST["os$OS[ID]"]) AND $_POST["os$OS[ID]"] == "$OS[ID]"){
                            Add_Command_OS($CommandID[0]['ID'], $_POST["os$OS[ID]"], $_POST["$OS[ID]"]);
                        } else{
                            continue;
                        }
                    }
                }
            } catch(Exception $e) {
                die('Erreur : '.$e->getMessage());
            }?>
    </body>
</html>