$('.os').click(function() {
    //e.preventDefault();
    $('#app').empty();
    $("#nogroup").attr("checked", true);
    var IDOS = $('input[name="radioOS"]:checked').val();

    // Vérifier si un bouton radio est sélectionné
    if (IDOS) {
        console.log('La valeur sélectionnée est : ' + IDOS);
        $.ajax({
            url: './assets/fonctions/Fonctions.php',
            type: 'POST',
            data: {
                fonction: "Get_ApplicationsByIDOS",
                radioOS: IDOS,
            },
            success: function(response) {
                // Parcourir les données et créer un bouton pour chaque entrée
                response = JSON.parse(response);
                $.each(response, function(i, element) {
                    // Créer l'élément de bouton
                    var newCheckbox = $('<input>').attr({
                        id: 'app' + element['ID'],
                        type: 'checkbox',
                        name: 'app' + element['ID'],
                        class: 'application',
                        value: element['ID'],
                    });
                    // Créer l'élément de label
                    var newLabel = $('<label>').attr({
                        for: element['ID'],
                    }).text(element['CommonName']);

                    // Ajouter le bouton et le label à l'élément parent
                    $('#app').append(newCheckbox);
                    $('#app').append(newLabel);
                    });
            },
            error: function() {
              // Gérer les erreurs de requête AJAX
                console.log('Une erreur est survenue lors de la récupération des données de checkbox.');
            }
        });
    } else {
        console.log('Aucun bouton radio sélectionné.');
    }
});

$('.groupgroup').click(function() {
    $('#app').empty();
    $("#noos").attr("checked", true);
    var GroupID = $('input[name="radioGroup"]:checked').val();

    // Vérifier si un bouton radio est sélectionné
    if (GroupID) {
        console.log('La valeur sélectionnée est : ' + GroupID);
        $.ajax({
            url: './assets/fonctions/Fonctions.php',
            type: 'POST',
            data: {
                fonction: "Get_ApplicationsByGroupID",
                radioGroup: GroupID,
            },
            success: function(response) {
                // Parcourir les données et créer un bouton pour chaque entrée
                response = JSON.parse(response);
                $.each(response, function(i, element) {
                    // Créer l'élément de bouton
                    var newCheckbox = $('<input>').attr({
                        id: 'app' + element['ID'],
                        type: 'checkbox',
                        name: 'app' + element['ID'],
                        class: 'application',
                        value: element['ID'],
                    });
                    // Créer l'élément de label
                    var newLabel = $('<label>').attr({
                        for: 'app' + element['ID'],
                    }).text(element['CommonName']);

                    // Ajouter le bouton et le label à l'élément parent
                    $('#app').append(newCheckbox);
                    $('#app').append(newLabel);
                    });
            },
            error: function() {
              // Gérer les erreurs de requête AJAX
                console.log('Une erreur est survenue lors de la récupération des données de checkbox.');
            }
        });
    } else {
        console.log('Aucun bouton radio sélectionné.');
    }
});

$('#app').click(function() {
    $('#cmd').empty();
    var AppID = [];
    var IDOS = $('input[name="radioOS"]:checked').val();
    $('input[class="application"]:checked').each(function() {
        AppID.push($(this).val());
    });

    // Vérifier si un bouton radio est sélectionné
    if (AppID && IDOS) {
        console.log('Les valeurs sélectionnées sont : ' + AppID + ' et ' + IDOS);
        $.ajax({
            url: './assets/fonctions/Fonctions.php',
            type: 'POST',
            data: {
                fonction: "Get_CommandeByAppAndOS",
                application: AppID,
                radioOS: IDOS,
            },
            success: function(response) {
                // Parcourir les données et créer un bouton pour chaque entrée
                response = JSON.parse(response);
                $.each(response, function(i, element) {
                    // Créer l'élément de bouton
                    var newradiobutton = $('<input>').attr({
                        id: 'cmd' + element['ID'],
                        type: 'checkbox',
                        name: 'cmd' + element['ID'],
                        class: 'command',
                        value: element['ID'],
                    });
                    // Créer l'élément de label
                    var newLabel = $('<label>').attr({
                        for: 'cmd' + element['ID'],
                    }).text(element['Libelle']);
                    // Ajouter le bouton et le label à l'élément parent
                    $('#cmd').append(newradiobutton);
                    $('#cmd').append(newLabel);
                    });
            },
            error: function() {
                // Gérer les erreurs de requête AJAX
                console.log('Une erreur est survenue lors de la récupération des données de checkbox.');
            }
        });
    } else {
        console.log('Aucun bouton radio sélectionné.');
    }
});

$("#divapp").hide();
$("#divcmd").hide();

$(".os").click(function (e) {
    $("#divapp").show();
});
$(".groupgroup").click(function (e) {
    $("#divapp").show();
});
$("#app").click(function (e) {
    $("#divcmd").show();
});

// Déclarer la variable currentTab en dehors de toutes les fonctions
var currentTab;

// Récupérer l'élément de la page qui contient les onglets
var tabContainer = document.querySelector(".nav.nav-justified");

// Ajouter un écouteur d'événement sur le conteneur des onglets pour détecter les changements d'onglet
tabContainer.addEventListener("click", function(event) {
    // Récupérer l'onglet actif
    var activeTab = document.activeElement;
    // Vérifier si l'élément actif est un lien d'onglet (a.nav-link)
    if (activeTab.classList.contains("nav-link")) {
        // Récupérer l'ID de l'onglet actif à partir de l'attribut "href" du lien d'onglet
        var activeTabId = activeTab.getAttribute("href").substring(1);
        // Afficher l'ID de l'onglet actif dans la console
        console.log("Onglet actif: " + activeTabId);
        // Enregistrer l'ID de l'onglet actif dans la variable currentTab
        currentTab = activeTabId;
    }
});

$(".num").click(function (e) {
    document.getElementById(currentTab).focus();
});

function modifierLigne(bouton) {
    var ligne = bouton.parentNode.parentNode;
    var cellules = ligne.getElementsByTagName("td");
    
    if (currentTab === "tab-group"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {} 
            else if (i === 4){} 
            else if (i === 5 ){} 
            else if (i === 7 ){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-action"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {} 
            else if (i === 2){} 
            else if (i === 3){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-commande"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {} 
            else if (i === 3){} 
            else if (i === 4){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-commande_os"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {} 
            else if (i === 5){} 
            else if (i === 6){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-application"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {} 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 8){} 
            else if (i === 9){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-ansible_cron"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {} 
            else if (i === 3){} 
            else if (i === 4){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-hypervisor"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 2){}  
            else if (i === 3){} 
            else if (i === 4){} 
            else if (i === 6){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-ipserver"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 4){}  
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else if (i === 8){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-os"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 4){}  
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 8){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-poolip"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 3){}  
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else if (i === 10){} 
            else if (i === 11){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-serverapps"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 5){}  
            else if (i === 6){} 
            else if (i === 7){} 
            else if (i === 8){} 
            else if (i === 9){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-servergroup"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 3){}  
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else if (i === 8){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-servers"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 1){}  
            else if (i === 2){}  
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else if (i === 8){} 
            else if (i === 9){} 
            else if (i === 10){} 
            else if (i === 11){} 
            else if (i === 12){} 
            else if (i === 13){} 
            else if (i === 15){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    } else if (currentTab === "tab-vlan"){
        for (var i = 0; i < cellules.length; i++) {
            if (i === 0) {}
            else if (i === 5){}  
            else if (i === 6){} 
            else if (i === 7){} 
            else if (i === 9){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                var contenu = cellules[i].innerHTML;
                cellules[i].innerHTML = "<input type='text'value='" + contenu + "'>";
            }
        }
    }
    
    var boutonEnregistrer = document.createElement("button");
    boutonEnregistrer.innerHTML = "Enregistrer";
    boutonEnregistrer.setAttribute("class", "btn btn-primary");
    boutonEnregistrer.onclick = function() { enregistrerLigne(ligne); };

    cellules[cellules.length - 2].innerHTML = "";
    cellules[cellules.length - 2].appendChild(boutonEnregistrer);
}

function enregistrerLigne(row) {

    var inputs = row.getElementsByTagName("input");
    var valeurs = [];
    var id = row.cells[0].innerHTML;
    valeurs.push(id);
    for (var i = 0; i < inputs.length; i++) {
        valeurs.push(inputs[i].value);
    }

    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i].querySelector("input");
        if (input) {
            var contenu = input.value;
            inputs[i].innerHTML = contenu;
        }
    }

    var boutonModifier = document.createElement("button");
    boutonModifier.innerHTML = "Modifier";
    boutonModifier.setAttribute("class", "btn btn-primary");
    boutonModifier.onclick = function() { modifierLigne(this); };
    inputs[inputs.length - 1].innerHTML = "";
    inputs[inputs.length - 1].appendChild(boutonModifier);

    if (currentTab === "tab-group"){
        // Envoi des données à la page PHP via $.ajax
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Groups",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log(valeurs);
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-action"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Action",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-commande"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Commande",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-commande_os"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Commande_OS",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-application"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Applications",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-ansible_cron"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Ansible_Cron",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-hypervisor"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Hypervisor",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-ipserver"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_IpServer",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-os"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_OS",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-poolip"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_PoolIP",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-serverapps"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_ServerApps",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-servergroup"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_ServerGroup",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-servers"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Update_Servers",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Ligne supprimée !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    }
    location.reload();
}

function supprimerLigne(bouton) {
    var ligne = bouton.parentNode.parentNode;
    var boutonSupprimer = document.createElement("button");
    boutonSupprimer.innerHTML = "Supprimer";
    boutonSupprimer.setAttribute("class", "btn btn-danger");
    boutonSupprimer.onclick = function() { supprimerLigne(ligne); };
    var id = ligne.cells[0].innerHTML;

    // Afficher une boîte de dialogue de confirmation
    if (confirm("Voulez-vous vraiment supprimer cette ligne ?")) {

        // Supprimer la ligne de la table
        ligne.parentNode.removeChild(ligne);

        // Envoyer la requête pour supprimer la ligne dans la base de données via $.ajax
        if (currentTab === "tab-group"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Groups",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-action"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Action",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-commande"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Commande",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-commande_os"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Commande_OS",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-application"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Applications",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-ansible_cron"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Ansible_Cron",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-hypervisor"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Hypervisor",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-ipserver"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_IpServer",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-os"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_OS",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-poolip"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_PoolIP",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-serverapps"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_ServerApps",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-servergroup"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_ServerGroup",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-servers"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_Servers",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        } else if (currentTab === "tab-vlan"){
            $.ajax({
                url: "./assets/fonctions/Fonctions.php",
                method: "POST",
                data: {
                    fonction: "Delete_VLAN",
                    id: id,
                },
                success: function(response) {
                    console.log("Ligne supprimée !");
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
                }
            });
        }
        location.reload();
    }
}

function addRow() {
    
    if (currentTab === "tab-group"){
        var table = document.getElementById("tableGroups");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;
        // Insérer la nouvelle ligne avec les champs
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
                } 
            else if (i === 4){} 
            else if (i === 5 ){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-action"){
        var table = document.getElementById("tableAction");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 2){} 
            else if (i === 3 ){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-commande"){
        var table = document.getElementById("tableCommande");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 3){} 
            else if (i === 4){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-commande_os"){
        var table = document.getElementById("tableCommande_OS");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 5){} 
            else if (i === 6){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-application"){
        var table = document.getElementById("tableApplications");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 8){} 
            else if (i === 9){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-ansible_cron"){
        var table = document.getElementById("tableAnsible_Cron");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 3){} 
            else if (i === 4){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-hypervisor"){
        var table = document.getElementById("tableHypervisor");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 2){} 
            else if (i === 3){} 
            else if (i === 4){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-ipserver"){
        var table = document.getElementById("tableIpServer");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-os"){
        var table = document.getElementById("tableOS");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-poolip"){
        var table = document.getElementById("tablePoolIP");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 3){} 
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-serverapps"){
        var table = document.getElementById("tableServerApps");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-serverapps"){
        var table = document.getElementById("tableServerApps");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 3){} 
            else if (i === 4){} 
            else if (i === 5){} 
            else if (i === 6){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-servers"){
        var table = document.getElementById("tableServers");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 7){} 
            else if (i === 8){} 
            else if (i === 9){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    } else if (currentTab === "tab-vlan"){
        var table = document.getElementById("tableVLAN");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount - 1);
        var cellCount = table.rows[0].cells.length;

        // Générer l'ID en fonction de la ligne précédente
        var lastRow = table.rows[rowCount - 2];
        var lastId = parseInt(lastRow.cells[0].innerHTML);
        var newId = lastId + 1;

        // Générer l'ID en fonction de la ligne précédente
        for (var i = 0; i < cellCount; i++) {
            var cell = row.insertCell(i);
            if (i === 0) {
                // Ajouter l'ID à la première colonne
                cell.innerHTML = newId;
            } 
            else if (i === 5){} 
            else if (i === 6){} 
            else if (i === 7){} 
            else {
                // Ajouter un champ text pour les autres colonnes
                cell.innerHTML = '<input type="text">';
            }
        }
    }
    // Ajouter le bouton Enregistrer
    var cell = row.insertCell(cellCount);
    var boutonEnregistrer = document.createElement("button");
    boutonEnregistrer.innerHTML = "Enregistrer";
    boutonEnregistrer.setAttribute("class", "btn btn-primary");
    boutonEnregistrer.onclick = function () {
        enregistrerNewLigne(row);
    };
    cell.appendChild(boutonEnregistrer);

    // Supprimer la ligne "Ajouter une ligne"
    table.deleteRow(rowCount);

    // Ajouter la nouvelle ligne "Ajouter une ligne"
    var lastRow = table.insertRow(table.rows.length);
    var cell = lastRow.insertCell(0);
    cell.colSpan = cellCount + 1; // Fusion des cellules
    var boutonAjouter = document.createElement("button");
    boutonAjouter.innerHTML = "Ajouter une ligne";
    boutonAjouter.setAttribute("class", "btn btn-primary");
    boutonAjouter.onclick = function () {
        addRow();
    };
    cell.appendChild(boutonAjouter);
}

function enregistrerNewLigne(row) {
    var inputs = row.getElementsByTagName("input");
    var valeurs = [];
    for (var i = 0; i < inputs.length; i++) {
        valeurs.push(inputs[i].value);
    }

    if (currentTab === "tab-group"){
        // Envoi des données à la page PHP via $.ajax
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Groups",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log(valeurs);
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-action"){    
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Action",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-commande"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Commande",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-commande_os"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Commande_OS",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-application"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Applications",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-ansible_cron"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Ansible_Cron",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-hypervisor"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Hypervisor",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-ipserver"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_IpServer",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-os"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_OS",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-poolip"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_PoolIP",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-serverapps"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_ServerApps",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-servergroup"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_ServerGroup",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-servers"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_Servers",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    } else if (currentTab === "tab-vlan"){
        $.ajax({
            url: "./assets/fonctions/Fonctions.php",
            method: "POST",
            data: {
                fonction: "Insert_VLAN",
                valeurs: valeurs,
            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de l'envoi des données : " + textStatus, errorThrown);
            }
        });
    }
    location.reload();
}

// Récupération du conteneur de la table
const tableContainer = document.getElementById('tableContainer');

// Ajout du gestionnaire d'événements de défilement à la fenêtre
window.addEventListener('scroll', () => {
  // Vérification de la position de défilement de la page
    if (window.scrollY > tableContainer.offsetTop - window.innerHeight / 2) {
        // Affichage de la table
        tableContainer.style.opacity = 1;
    }
});