<?php
    require('./assets/fonctions/Fonctions.php');
    $Groups = Get_Groups();
    $Applications = Get_Applications();
    $Commandes = Get_Commande();
    $OSs = Get_OS();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion Ansible</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/more.css">
    <script src="./assets/js/jquery.js"></script>
</head>

<body>
<form id="form1" method="post">
    <div style="text-align: center;"> 
        <div class="app-main__inner">
            <div class="app-page-title">
                <h3>Panneau de gestion des playbooks Ansible</h3>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="text-center">
                        
                            <h5 class="card-title">Pour les Groupes :</h5>
                                <div role="group" class="checkbox-wrapper-13">
                                    <?php
                                        try {
                                            echo "<div style='display: block'>";
                                            // Création des checkbox pour les groupes
                                            foreach ($Groups as $Group) {
                                                echo "<input type='radio' id='group$Group[ID]' name='radioGroup' class='border_spacing groupgroup' value='$Group[ID]' ";
                                                // On vérifie que la checkbox a bien été cochée si c'est le cas on la laisse cocher même aprés l'envoi du formulaire
                                                if(isset($_POST['Submit'])) {
                                                    if (isset($_POST["radioGroup"]) AND $_POST["radioGroup"] == "on"){
                                                        echo" checked";
                                                    }
                                                }
                                                echo">";
                                                echo"<label for='radioGroup'>" . ucfirst($Group["GroupName"]) . "</label>";}
                                                echo "<input type='radio' name='radioGroup' class='border_spacing' value='None' id='nogroup' ";
                                                echo"<label for='radioGroup'> Aucun </label>";
                                                echo "</div>";
                                        } catch(Exception $e) {
                                            die('Erreur : '.$e->getMessage());
                                        }?>
                                </div>
                            <div class="divider"></div>
                            <h5 class="card-title">Pour les OS :</h5>
                            <div role="group" class="checkbox-wrapper-13">
                                <?php
                                    try {
                                        echo "<div style='display: block'>";
                                        // Création des checkbox pour les OS
                                        foreach ($OSs as $OS) {
                                            echo "<input type='radio' id='os$OS[ID]' name='radioOS' class='border_spacing os' value='$OS[ID]' ";
                                            // On vérifie que la checkbox a bien été cochée si c'est le cas on la laisse cocher même aprés l'envoi du formulaire
                                            if(isset($_POST['Submit'])) {
                                                if (isset($_POST["radioOS"]) AND $_POST["radioOS"] == "on"){
                                                    echo" checked";
                                                }
                                            }
                                        echo">";
                                        echo"<label for='radioOS'>" . ucfirst($OS["Name"]) . "</label>";}
                                        echo "<input type='radio' name='radioOS' class='border_spacing' value='None' id='noos' ";
                                        echo"<label for='radioOS'> Aucun </label>";
                                        echo "</div>";
                                    } catch(Exception $e) {
                                        die('Erreur : '.$e->getMessage());
                                    }?>
                            </div>
                            <div id='divapp'>
                                <div class="divider"></div>
                                <h5 class="card-title">Pour les Groupes d'applications :</h5>
                                <div role="group" class="checkbox-wrapper-13"  id='app' >
                                </div>
                            </br>
                            </div>
                        </div>
                    <div id='divcmd'>
                        <div class="divider"></div>
                        <h5 class="card-title">Commande pour les Playbooks :</h5>
                        <div class="checkbox-wrapper-13" id='cmd'>
                        </div>
                    </div>
                    
                    <div class="divider"></div>
                    <div role="group" class="btn-group-lg btn-group">
                        <button type="submit" form="form1" name="Submit" class="btn btn-primary">Soumettre</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/js/main.js"></script>
    <script type="text/javascript" src="./assets/js/mainajax.js"></script>
    <a href="./Action.php">Action</a>
    <a href="./Commande.php">Commande</a>
    <a href="./Management.php">Management</a>
    <?php
        try {
            // On vérifie que le formulaire à bien été soumis
            if (isset($_POST['Submit'])) {
                try {
                    // on créer des tableaux vide qui vont contenir l'information de quelle case à été cochée.
                    $Array_Post_Groups = [];
                    $Array_Post_OSs = [];
                    $Array_Post_Applications = [];
                    $Array_Post_Commande = [];
                    
                    // On vérifie que la variable existe et on vérifie que la case à bien été cochée pour les groupes
                    if (isset($_POST["radioGroup"]) AND $_POST["radioGroup"] != "None"){
                        array_push($Array_Post_Groups, $_POST["radioGroup"]);
                    }
                    // On vérifie que le tableau n'est pas vide
                    $lenArray_Post_Groups = count($Array_Post_Groups);
                    if ($lenArray_Post_Groups == 0) {
                        array_push($Array_Post_Groups, "None");
                    }

                    // On vérifie que la variable existe et on vérifie que la case à bien été cochée pour les OS
                    if (isset($_POST["radioOS"]) AND $_POST["radioOS"] != "None"){
                        array_push($Array_Post_OSs, $_POST["radioOS"]);
                    }
                    // On vérifie que le tableau n'est pas vide
                    $lenArray_Post_OSs = count($Array_Post_OSs);
                    if ($lenArray_Post_OSs == 0) {
                        array_push($Array_Post_OSs, "None");
                    }

                    foreach ($Applications as $Application) {
                        // On vérifie que la variable existe et on vérifie que la case à bien été cochée pour les applications
                        if (isset($_POST["app$Application[ID]"]) AND $_POST["app$Application[ID]"] == $Application["ID"]){
                            array_push($Array_Post_Applications, $_POST["app$Application[ID]"]);
                        } else{
                            continue;
                        }
                    }
                    // On vérifie que le tableau n'est pas vide
                    $lenArray_Post_Applications = count($Array_Post_Applications);
                    if ($lenArray_Post_Applications == 0) {
                        array_push($Array_Post_Applications, "None");
                    }
                    
                    foreach ($Commandes as $Commande) {
                        // On vérifie que la variable existe et on vérifie que la case à bien été cochée pour les commandes
                        if (isset($_POST["cmd$Commande[ID]"])){
                            array_push($Array_Post_Commande, $_POST["cmd$Commande[ID]"]);
                        } else{
                            continue;
                        }
                    }
                    // On vérifie que le tableau n'est pas vide
                    $lenArray_Post_Commande = count($Array_Post_Commande);
                    if ($lenArray_Post_Commande == 0) {
                        array_push($Array_Post_Commande, "None");
                    }

                } catch(Exception $e) {
                    die('Erreur : '.$e->getMessage());
                }
                try {
                    // On traite la valeur obtenue pour avoir le format que l'on souhaite
                    $Post_Groups = implode("', '", $Array_Post_Groups);
                    $Post_Groups = "('$Post_Groups')";
                    $Post_OSs = implode("', '", $Array_Post_OSs);
                    $Post_OSs = "('$Post_OSs')";
                    $Post_Applications = implode("', '", $Array_Post_Applications);
                    $Post_Applications = "('$Post_Applications')";
                    $Post_Commande = implode("', '", $Array_Post_Commande);
                    $Post_Commande = "('$Post_Commande')";
                    // Préparation de la commande qui va être exécutée par le script python
                    $command_exec = "python script/Ansible-groups-creator.py \"$Post_Groups\" \"$Post_OSs\" \"$Post_Applications\" \"$Post_Commande\"";
                    // On exécute le script python qui va créer le playbook et le fichier host
                    $str_output = shell_exec($command_exec);
                } catch(Exception $e) {
                    die('Erreur : '.$e->getMessage());
                }
            }
        } catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
        }

    ?>


<!-- <button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#exampleModal">
Basic Modal
</button>

<script type="text/javascript" src="./assets/js/modal.js"></script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<p class="mb-0">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div> -->
    </form>
</body>
</html>