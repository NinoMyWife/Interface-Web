<?php
    require('./assets/fonctions/Fonctions.php');
    $Groups = Get_All_From_Groups();
    $Actions = Get_All_From_Action();
    $Commandes = Get_All_From_Commande();
    $Commandes_OSs = Get_All_From_Commande_OS();
    $Applications = Get_All_From_Applications();
    $Ansible_Crons = Get_All_From_Ansible_Cron();
    $Hypervisors = Get_All_From_Hypervisor();
    $IpServers = Get_All_From_IpServer();
    $OSs = Get_All_From_OS();
    $PoolIPs = Get_All_From_PoolIP();
    $ServerApps = Get_All_From_ServerApps();
    $ServerGroups = Get_All_From_ServerGroup();
    $Servers = Get_All_From_Servers();
    $VLANs = Get_All_From_VLAN();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Management de la base ansible</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/more.css">
    <script src="./assets/js/jquery.js"></script>
</head>

    <body>
        <div style="text-align: center;"> 
            <div class="app-main__inner">
                <div class="app-page-title">
                    <h3>Page de management de la base ansible</h3>
                    <div class="mb-3 card">
                        <div class="card-header">
                            <ul class="nav nav-justified">
                                <li class="nav-item"><a data-toggle="tab" href="#tab-group" class="nav-link">Table Groups</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-action" class="nav-link">Table Action</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-ansible_cron" class="nav-link">Table Ansible Cron</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-application" class="nav-link">Table Applications</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-commande" class="nav-link">Table Commande</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-commande_os" class="nav-link">Table Commande OS</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-hypervisor" class="nav-link">Table Hypervisor</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-ipserver" class="nav-link">Table IpServer</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-os" class="nav-link">Table OS</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-poolip" class="nav-link">Table PoolIP</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-serverapps" class="nav-link">Table ServerApps</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-servergroup" class="nav-link">Table ServerGroup</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-servers" class="nav-link">Table Servers</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-vlan" class="nav-link">Table VLAN</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" id="tab-group" role="tabpanel">
                                <TABLE border="1" class="table" id="tableGroups">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Groups[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Groups[1] as $Group) {
                                            echo "<tr>";
                                            foreach ($Group as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-action" role="tabpanel">
                                <TABLE border="1" class="table" id="tableAction">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Actions[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Actions[1] as $Action) {
                                            echo "<tr>";
                                            foreach ($Action as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-ansible_cron" role="tabpanel">
                                <TABLE border="1" class="table" id="tableAnsible_Cron">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Ansible_Crons[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Ansible_Crons[1] as $Ansible_Cron) {
                                            echo "<tr>";
                                            foreach ($Ansible_Cron as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-application" role="tabpanel">
                                <TABLE border="1" class="table" id="tableApplications">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Applications[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Applications[1] as $Application) {
                                            echo "<tr>";
                                            foreach ($Application as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-commande" role="tabpanel">
                                <TABLE border="1" class="table" id="tableCommande">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Commandes[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Commandes[1] as $Commande) {
                                            echo "<tr>";
                                            foreach ($Commande as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-commande_os" role="tabpanel">
                                <TABLE border="1" class="table" id="tableCommande_OS">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Commandes_OSs[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Commandes_OSs[1] as $Commandes_OS) {
                                            echo "<tr>";
                                            foreach ($Commandes_OS as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-hypervisor" role="tabpanel">
                                <TABLE border="1" class="table" id="tableHypervisor">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Hypervisors[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Hypervisors[1] as $Hypervisor) {
                                            echo "<tr>";
                                            foreach ($Hypervisor as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-ipserver" role="tabpanel">
                                <TABLE border="1" class="table" id="tableIpServer">
                                    <?php
                                        echo "<tr>";
                                        foreach ($IpServers[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($IpServers[1] as $IpServer) {
                                            echo "<tr>";
                                            foreach ($IpServer as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-os" role="tabpanel">
                                <TABLE border="1" class="table" id="tableOS">
                                    <?php
                                        echo "<tr>";
                                        foreach ($OSs[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($OSs[1] as $OS) {
                                            echo "<tr>";
                                            foreach ($OS as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-poolip" role="tabpanel">
                                <h5 class="card-title">Insérer une tranche IP :</h5>
                                <label for='ip'>Veuillez saisir une ip : </label>
                                <input type='text' style='margin-left: 5px; margin-right: 1em;' id='ip-add' name='ip-add'>
                                <label for='subnet'>Veuillez entrer le subnet : </label>
                                <input type='text' style='margin-left: 5px; margin-right: 5px;' id='subnet-add' name='subnet-add'>
                                <button type="submit" name="SubmitIP-add" class="btn btn-primary">Executer</button>
                                <h5 class="card-title" style="margin-top: 1em">Supprimer une tranche IP :</h5>
                                <label for='ip'>Veuillez saisir une ip : </label>
                                <input type='text' style='margin-left: 5px; margin-right: 1em;' id='ip-del' name='ip-del'>
                                <label for='subnet'>Veuillez entrer le subnet : </label>
                                <input type='text' style='margin-left: 5px; margin-right: 5px;' id='subnet-del' name='subnet-del'>
                                <button type="submit" name="SubmitIP-del" class="btn btn-primary">Executer</button>
                                <div style= "margin-bottom: 2em;"></div>
                                <?php
                                // Nombre de lignes par page
                                $linesPerPage = 50;
                                // Page courante (par défaut : première page)
                                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                // Index de la première ligne à afficher
                                $startIndex = ($page - 1) * $linesPerPage;
                                // Index de la dernière ligne à afficher
                                $endIndex = $startIndex + $linesPerPage;
                                // Tableau de données
                                $data = $PoolIPs[1];
                                // Nombre total de lignes
                                $totalLines = count($data);
                                // Nombre total de pages
                                $totalPages = ceil($totalLines / $linesPerPage);
                                // Affichage du tableau
                                echo "<TABLE border=\"1\" class=\"table\" id=\"tablePoolIP\">";
                                echo "<tr>";
                                foreach ($PoolIPs[0] as $NomColonne) {
                                    echo "<th>" . $NomColonne . "</th>";
                                }
                                echo "</tr>";
                                echo "<div class='num'>";
                                for ($i = $startIndex; $i < $endIndex && $i < $totalLines; $i++) {
                                    $PoolIP = $data[$i];
                                    echo "<tr>";
                                    foreach ($PoolIP as $element) {
                                        echo "<td>" . $element . "</td>";
                                    }
                                    echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                    echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                    echo "</tr>";
                                }
                                echo "<div>";
                                echo "<tr><td colspan=\"8\">";
                                // Affichage des liens de pagination
                                for ($p = 1; $p <= $totalPages; $p++) {
                                    if ($p == $page) {
                                        echo "<span class=\"current-page\" nav-link show active>$p</span>";
                                    } else {
                                        echo "<a href=\"/Management.php?page=$p\">$p</a>";
                                    }
                                }
                                echo "</td></tr>";
                                echo "</TABLE>";
                                ?>
                                </div>
                                <div class="tab-pane" id="tab-serverapps" role="tabpanel">
                                <TABLE border="1" class="table" id="tableServerApps">
                                    <?php
                                        echo "<tr>";
                                        foreach ($ServerApps[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($ServerApps[1] as $ServerApp) {
                                            echo "<tr>";
                                            foreach ($ServerApp as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-servergroup" role="tabpanel">
                                <TABLE border="1" class="table" id="tableServerGroup">
                                    <?php
                                        echo "<tr>";
                                        foreach ($ServerGroups[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($ServerGroups[1] as $ServerGroup) {
                                            echo "<tr>";
                                            foreach ($ServerGroup as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-servers" role="tabpanel">
                                <TABLE border="1" class="table" id="tableServers">
                                    <?php
                                        echo "<tr>";
                                        foreach ($Servers[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($Servers[1] as $Server) {
                                            echo "<tr>";
                                            foreach ($Server as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                                <div class="tab-pane" id="tab-vlan" role="tabpanel">
                                <TABLE border="1" class="table" id="tableVLAN">
                                    <?php
                                        echo "<tr>";
                                        foreach ($VLANs[0] as $NomColonne) {
                                            echo "<th>" . $NomColonne . "</th>";
                                        }
                                        echo "</tr>";
                                        foreach ($VLANs[1] as $VLAN) {
                                            echo "<tr>";
                                            foreach ($VLAN as $element) {
                                            echo "<td>" . $element . "</td>";
                                            }
                                            echo '<td><button onclick="modifierLigne(this)" class="btn btn-primary">Modifier</button></td>';
                                            echo '<td><button onclick="supprimerLigne(this)" class="btn btn-danger">Supprimer</button></td>';
                                            echo "</tr>";
                                        }
                                    ?>
                                    <tr><td colspan="8"><button id="addRowButton" class="btn btn-primary" onclick="addRow()">Ajouter une ligne</button></td></tr>
                                </TABLE>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./assets/js/main2.js"></script>
        <script type="text/javascript" src="./assets/js/mainajax.js"></script>
    </body>
    <?php
        // Vérifie si le boutton "SubmitIP-add" a été appuyé
        if (isset($_POST['SubmitIP-add'])) {
            $InputIP = $_POST['ip-add'];
            $InputSubnet = $_POST['subnet-add'];
            // Génère dans la variable ips la tranche ip souhaité
            $ips = getIPsInRange("$InputIP", $InputSubnet);
            foreach ($ips as $ip) {
                // Insert_IP($ip);
            }
        }
        // Vérifie si le boutton "SubmitIP-del" a été appuyé
        if (isset($_POST['SubmitIP-del'])) {
            $InputIP = $_POST['ip-del'];
            $InputSubnet = $_POST['subnet-del'];
            // Génère dans la variable ips la tranche ip souhaité
            $ips = getIPsInRange("$InputIP", $InputSubnet);
            foreach ($ips as $ip) {
                // Delete_IP($ip);
            }
        }
    ?>