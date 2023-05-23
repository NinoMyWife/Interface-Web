<?php

function getIPsInRange($ip, $subnet) {
    $subnet = intval($subnet);
    $ip_long = ip2long($ip);
    $netmask_long = ~((1 << (32 - $subnet)) - 1);
    $network_long = $ip_long & $netmask_long;
    $broadcast_long = $network_long | ~$netmask_long;
    $ips = array();
    for ($i = $network_long + 1; $i < $broadcast_long; $i++) {
        $ips[] = long2ip($i);
    }
    return $ips;
}

function Get_Groups() {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, GroupName FROM Groups ORDER BY GroupName";

    // Execution de la requête 
    // $statement = $pdo->query($query);
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();
    return $demande;
}

function Get_Applications() {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, CommonName FROM Applications ORDER BY CommonName";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Get_OS() {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, Name FROM OS WHERE NAME NOT LIKE 'unknown'";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Get_Commande() {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, Libelle FROM Commande";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Get_CommandeByAppAndOS($IDOS, $IDApps) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT Commande.ID, Commande, Commande.Libelle FROM Commande_OS INNER JOIN Commande ON Commande.ID = Commande_OS.IDCMD WHERE IDOS = $IDOS";
    foreach ($IDApps as $IDApp) {
        $query .= " AND IDApp = $IDApp";
    }
    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Get_Action() {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, Action FROM Action";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Add_Action($Action) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "INSERT INTO Action (Action) VALUES ('$Action')";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
}

function Add_Command($IDAction, $Libelle) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "INSERT INTO Commande (IDAction, Libelle) VALUES ($IDAction, '$Libelle')";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
}

function Get_CommandID($Libelle) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID FROM Commande WHERE Libelle = '$Libelle'";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Add_Command_OS($IDCMD, $IDOS, $CMD, $IDApp=0) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "INSERT INTO Commande_OS (IDCMD, IDOS, Commande, IDApp) VALUES ($IDCMD, $IDOS, '$CMD', '$IDApp')";
    
    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
}

function Get_ApplicationsByIDOS($IDOS) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT CommonName, Applications.ID FROM Applications INNER JOIN OS ON Applications.IDOS = OS.ID INNER JOIN Groups ON Groups.GroupName = OS.`Type` WHERE Applications.IDOS = $IDOS ORDER BY CommonName";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Get_ApplicationsByGroupID($GroupID) {

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT CommonName, Applications.ID FROM Applications INNER JOIN OS ON Applications.IDOS = OS.ID INNER JOIN Groups ON Groups.GroupName = OS.`Type` WHERE Groups.ID = $GroupID ORDER BY CommonName";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll();

    return $demande;
}

function Get_All_From_Groups(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, GroupName, RegexProperties, Regex, InsertDate, UpdateDate  FROM Groups WHERE Deleted = 0";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Groups($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $GroupName = $valeurs[1];
        $RegexProperties = $valeurs[2];
        $Regex = $valeurs[3];
        $query = "UPDATE Groups SET GroupName = '$GroupName', RegexProperties = '$RegexProperties', Regex = '$Regex' WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Groups($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $GroupName = $valeurs[0];
        $RegexProperties = $valeurs[1];
        $Regex = $valeurs[2];
        $query = "INSERT INTO Groups (GroupName, RegexProperties, Regex, Deleted) VALUES ('$GroupName', '$RegexProperties', '$Regex')";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Groups($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Groups Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Action(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, Action FROM Action";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Action($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $Action = $valeurs[1];
        $query = "UPDATE Action SET Action = '$Action' WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Action($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $Action = $valeurs[0];
        $query = "INSERT INTO Action (Action) VALUES ('$Action')";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Action($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Action Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Commande(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM Commande";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Commande($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $Libelle = $valeurs[1];
        $IDAction = $valeurs[2];
        $query = "UPDATE Commande SET Libelle = '$Libelle', IDAction = $IDAction WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Commande($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $Libelle = $valeurs[0];
        $IDAction = $valeurs[1];
        $query = "INSERT INTO Commande (Libelle, IDAction) VALUES ('$Libelle', $IDAction)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Commande($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Commande Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Commande_OS(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM Commande_OS";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Commande_OS($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IDCMD = $valeurs[1];
        $IDOS = $valeurs[2];
        $Commande = $valeurs[3];
        $IDApp = $valeurs[4];
        $query = "UPDATE Commande_OS SET IDCMD = $IDCMD, IDOS = $IDOS, Commande = '$Commande', IDApp = $IDApp  WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Commande_OS($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDCMD = $valeurs[0];
        $IDOS = $valeurs[1];
        $Commande = $valeurs[2];
        $IDApp = $valeurs[3];
        $query = "INSERT INTO Commande_OS (IDCMD, IDOS, Commande, IDApp) VALUES ($IDCMD, $IDOS, '$Commande', $IDApp)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Commande_OS($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Commande_OS Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Applications(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT ID, IDAppParent, CommonName, ServiceNames, Version, InsertDate, UpdateDate, IDOS FROM Applications";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Applications($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IDAppParent = $valeurs[1];
        $CommonName = $valeurs[2];
        $ServiceNames = $valeurs[3];
        $Version = $valeurs[4];
        $InsertDate = $valeurs[5];
        $UpdateDate = $valeurs[6];
        $IDOS = $valeurs[7];
        $query = "UPDATE Applications SET IDAppParent = $IDAppParent, CommonName = '$CommonName', ServiceNames = '$ServiceNames', Version = '$Version', InsertDate= '$InsertDate', UpdateDate = '$UpdateDate', IDOS = '$IDOS' WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Applications($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDAppParent = $valeurs[0];
        $CommonName = $valeurs[1];
        $ServiceNames = $valeurs[2];
        $Version = $valeurs[3];
        $InsertDate = $valeurs[4];
        $UpdateDate = $valeurs[5];
        $IDOS = $valeurs[6];
        $query = "INSERT INTO Applications (IDAppParent, CommonName, ServiceNames, Version, InsertDate, UpdateDate, IDOS) VALUES ($IDAppParent, '$CommonName', '$ServiceNames', '$Version', '$InsertDate', '$UpdateDate', $IDOS)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Applications($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Applications Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Ansible_Cron(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM Ansible_Cron";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Ansible_Cron($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IDCMD = $valeurs[1];
        $Groupe = $valeurs[2];
        $query = "UPDATE Ansible_Cron SET IDCMD = $IDCMD, Groupe = '$Groupe' WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Ansible_Cron($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDCMD = $valeurs[0];
        $Groupe = $valeurs[1];
        $query = "INSERT INTO Ansible_Cron (IDCMD, Groupe) VALUES ($IDCMD, '$Groupe')";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Ansible_Cron($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Ansible_Cron Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Hypervisor(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM Hypervisor";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Hypervisor($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $Name = $valeurs[1];
        $query = "UPDATE Hypervisor SET Name = $Name WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Hypervisor($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $Name = $valeurs[0];
        $query = "INSERT INTO Ansible_Cron (Name) VALUES ($Name)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Hypervisor($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Hypervisor Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_IpServer(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM IpServer";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_IpServer($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IDPoolIP = $valeurs[1];
        $IDServer = $valeurs[2];
        $PublicVLAN = $valeurs[3];
        $query = "UPDATE IpServer SET IDPoolIP = $IDPoolIP, IDServer = $IDServer, PublicVLAN = $PublicVLAN WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_IpServer($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDPoolIP = $valeurs[1];
        $IDServer = $valeurs[2];
        $PublicVLAN = $valeurs[3];
        $query = "INSERT INTO IpServer (IDPoolIP, IDServer, PublicVLAN) VALUES ($IDPoolIP, $IDServer, $PublicVLAN)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_IpServer($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Hypervisor Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_OS(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM OS";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_OS($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $Name = $valeurs[1];
        $Type = $valeurs[2];
        $Version = $valeurs[3];
        $query = "UPDATE OS SET Name = $Name, Type = $Type, Version = $Version WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_OS($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $Name = $valeurs[1];
        $Type = $valeurs[2];
        $Version = $valeurs[3];
        $query = "INSERT INTO OS (Name, Type, Version) VALUES ($Name, $Type, $Version)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_OS($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From OS Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_PoolIP(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM PoolIP";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_PoolIP($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IP = $valeurs[1];
        $IDVLAN = $valeurs[2];
        $TopAnsible = $valeurs[3];
        $TopSkip = $valeurs[4];
        $query = "UPDATE PoolIP SET IP = $IP, IDVLAN = $IDVLAN, TopAnsible = $TopAnsible, TopSkip = $TopSkip WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_PoolIP($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IP = $valeurs[1];
        $IDVLAN = $valeurs[2];
        $TopAnsible = $valeurs[3];
        $TopSkip = $valeurs[4];
        $query = "INSERT INTO OS (IP, IDVLAN, TopAnsible, TopSkip) VALUES ($IP, $IDVLAN, $TopAnsible, $TopSkip)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_PoolIP($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From PoolIP Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_ServerApps(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM ServerApps";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_ServerApps($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IDServer = $valeurs[1];
        $IDApplication = $valeurs[2];
        $EffectiveAppPorts = $valeurs[3];
        $ToMonitor = $valeurs[4];
        $query = "UPDATE ServerApps SET IDServer = $IDServer, IDApplication = $IDApplication, EffectiveAppPorts = $EffectiveAppPorts, ToMonitor = $ToMonitor WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_ServerApps($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDServer = $valeurs[1];
        $IDApplication = $valeurs[2];
        $EffectiveAppPorts = $valeurs[3];
        $ToMonitor = $valeurs[4];
        $query = "INSERT INTO ServerApps (IDServer, IDApplication, EffectiveAppPorts, ToMonitor) VALUES ($IDServer, $IDApplication, $EffectiveAppPorts, $ToMonitor)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_ServerApps($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From ServerApps Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_ServerGroup(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM ServerGroup";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_ServerGroup($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $IDServer = $valeurs[1];
        $IdGroup = $valeurs[2];
        $query = "UPDATE ServerGroup SET IDServer = $IDServer, IdGroup = $IdGroup WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_ServerGroup($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDServer = $valeurs[1];
        $IdGroup = $valeurs[2];
        $query = "INSERT INTO ServerGroup (IDServer, IdGroup) VALUES ($IDServer, $IdGroup)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_ServerGroup($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From ServerGroup Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_Servers(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM Servers";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_Servers($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $Commonname = $valeurs[1];
        $query = "UPDATE Servers SET Commonname = $Commonname WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_Servers($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $IDHypervisor = $valeurs[1];
        $IDOS = $valeurs[2];
        $Commonname = $valeurs[3];
        $Hostname = $valeurs[4];
        $UserAnsible = $valeurs[5];
        $PassAnsible = $valeurs[6];
        $OldPassansible = $valeurs[7];
        $UserAdmin = $valeurs[8];
        $PassAdmin = $valeurs[9];
        $query = "INSERT INTO Servers (IDHypervisor, IDOS, Commonname, Hostname, UserAnsible, PassAnsible, OldPassansible, UserAdmin, PassAdmin) VALUES ($IDHypervisor, $IDOS, $Commonname, $Hostname, $UserAnsible, $PassAnsible, $OldPassansible, $UserAdmin, $PassAdmin)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_Servers($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From Servers Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Get_All_From_VLAN(){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
    $query = "SELECT * FROM VLAN";

    // Execution de la requête 
    $statement = $pdo->prepare($query);
    $statement->execute();
    $demande = $statement->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_keys($demande[0]);
    $firstRow = $statement->fetch(PDO::FETCH_ASSOC);
    if ($firstRow !== false) {
        array_unshift($demande, $firstRow);
    }
    return [$columns, $demande];
}

function Update_VLAN($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $ID = $valeurs[0];
        $Name = $valeurs[1];
        $NumVLAN = $valeurs[2];
        $Public = $valeurs[3];
        $IsCustomer = $valeurs[4];
        $query = "UPDATE VLAN SET Name = $Name, NumVLAN = $NumVLAN, Public = $Public, IsCustomer = $IsCustomer WHERE ID = $ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function Insert_VLAN($valeurs){

    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $Name = $valeurs[1];
        $NumVLAN = $valeurs[2];
        $Public = $valeurs[3];
        $IsCustomer = $valeurs[4];
        $query = "INSERT INTO Servers (Name, NumVLAN, Public, IsCustomer) VALUES ($Name, $NumVLAN, $Public, $IsCustomer)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_VLAN($id){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From VLAN Where ID = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Insert_IP($ip){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "INSERT INTO PoolIP (IP) VALUES $ip";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

function Delete_IP($ip){
    try {
        $pdo = new PDO('mysql:host=XXXXXXX; port=XXXXXXX; dbname=XXXXXXX', 'XXXXXXX', 'XXXXXXX');
        $query = "Delete From PoolIP Where IP = $ip";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
}

if (isset($_POST['fonction']) and $_POST['fonction'] == 'Get_ApplicationsByIDOS') {
    $radioOS = $_POST['radioOS'];
    $retour = Get_ApplicationsByIDOS($radioOS);
    echo json_encode($retour);
}

if (isset($_POST['fonction']) and $_POST['fonction'] == 'Get_ApplicationsByGroupID') {
    $radioGroup = $_POST['radioGroup'];
    $retour = Get_ApplicationsByGroupID($radioGroup);
    echo json_encode($retour);
}

if (isset($_POST['fonction']) and $_POST['fonction'] == 'Get_CommandeByAppAndOS') {
    $radioOS = $_POST['radioOS'];
    $application = $_POST['application'];
    $retour = Get_CommandeByAppAndOS($radioOS, $application);
    echo json_encode($retour);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Groups') {
    $valeurs = $_POST['valeurs'];
    Update_Groups($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Groups') {
    $valeurs = $_POST['valeurs'];
    Insert_Groups($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Groups') {
    $id = $_POST['id'];
    Delete_Groups($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Action') {
    $valeurs = $_POST['valeurs'];
    Update_Action($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Action') {
    $valeurs = $_POST['valeurs'];
    Insert_Action($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Action') {
    $id = $_POST['id'];
    Delete_Action($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Commande') {
    $valeurs = $_POST['valeurs'];
    Update_Commande($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Commande') {
    $valeurs = $_POST['valeurs'];
    Insert_Commande($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Commande') {
    $id = $_POST['id'];
    Delete_Commande($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Commande_OS') {
    $valeurs = $_POST['valeurs'];
    Update_Commande_OS($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Commande_OS') {
    $valeurs = $_POST['valeurs'];
    Insert_Commande_OS($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Commande_OS') {
    $id = $_POST['id'];
    Delete_Commande_OS($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Applications') {
    $valeurs = $_POST['valeurs'];
    Update_Applications($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Applications') {
    $valeurs = $_POST['valeurs'];
    Insert_Applications($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Applications') {
    $id = $_POST['id'];
    Delete_Applications($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Ansible_Cron') {
    $valeurs = $_POST['valeurs'];
    Update_Ansible_Cron($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Ansible_Cron') {
    $valeurs = $_POST['valeurs'];
    Insert_Ansible_Cron($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Ansible_Cron') {
    $id = $_POST['id'];
    Delete_Ansible_Cron($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Hypervisor') {
    $valeurs = $_POST['valeurs'];
    Update_Hypervisor($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Hypervisor') {
    $valeurs = $_POST['valeurs'];
    Insert_Hypervisor($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Hypervisor') {
    $id = $_POST['id'];
    Delete_Hypervisor($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_IpServer') {
    $valeurs = $_POST['valeurs'];
    Update_IpServer($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_IpServer') {
    $valeurs = $_POST['valeurs'];
    Insert_IpServer($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_IpServer') {
    $id = $_POST['id'];
    Delete_IpServer($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_OS') {
    $valeurs = $_POST['valeurs'];
    Update_OS($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_OS') {
    $valeurs = $_POST['valeurs'];
    Insert_OS($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_OS') {
    $id = $_POST['id'];
    Delete_OS($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_PoolIP') {
    $valeurs = $_POST['valeurs'];
    Update_PoolIP($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_PoolIP') {
    $valeurs = $_POST['valeurs'];
    Insert_PoolIP($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_PoolIP') {
    $id = $_POST['id'];
    Delete_PoolIP($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_ServerApps') {
    $valeurs = $_POST['valeurs'];
    Update_ServerApps($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_ServerApps') {
    $valeurs = $_POST['valeurs'];
    Insert_ServerApps($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_ServerApps') {
    $id = $_POST['id'];
    Delete_ServerApps($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_ServerGroup') {
    $valeurs = $_POST['valeurs'];
    Update_ServerGroup($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_ServerGroup') {
    $valeurs = $_POST['valeurs'];
    Insert_ServerGroup($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_ServerGroup') {
    $id = $_POST['id'];
    Delete_ServerGroup($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_Servers') {
    $valeurs = $_POST['valeurs'];
    Update_Servers($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_Servers') {
    $valeurs = $_POST['valeurs'];
    Insert_Servers($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_Servers') {
    $id = $_POST['id'];
    Delete_Servers($id);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Update_VLAN') {
    $valeurs = $_POST['valeurs'];
    Update_VLAN($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Insert_VLAN') {
    $valeurs = $_POST['valeurs'];
    Insert_VLAN($valeurs);
}

if (isset($_POST['fonction']) && $_POST['fonction'] == 'Delete_VLAN') {
    $id = $_POST['id'];
    Delete_VLAN($id);
}

?>