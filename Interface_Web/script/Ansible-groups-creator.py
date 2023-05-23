##########################################################################
# * Importation des bibliotheques
##########################################################################



import sys
import mysql.connector
from Class_Logs import Class_Logs
from Class_MySQL import Class_MySQL
from Class_WinRM import Class_WinRM
from Class_Ansible_Security import Class_Ansible_Security



##########################################################################
# * Début du script
##########################################################################



MyObjLog = Class_Logs()
MyObjLog.directory= "/var/www/html/"
MyObjLog.filename= "Log-Ansible-groups-creator.txt"
MyObjLog.writemode = 'w'
MaBDD = Class_MySQL(MyObjLog)
MonWinRM = Class_WinRM(MyObjLog)
MonAnsibleSecurity = Class_Ansible_Security(MyObjLog, MonWinRM, MaBDD)
MaBDD.NameBDD = "Test_main_auto_discovery"

try :

    Group = sys.argv[1]
    OS = sys.argv[2]
    Application = sys.argv[3]
    IDCommandeAnsible = sys.argv[4]

    if Group and OS and Application and IDCommandeAnsible == "('None')" : 
        MyObjLog.AjouteLog(f"Des valeurs n'ont pas été sélectionnées")
    if Application and IDCommandeAnsible == "('None')" :
        MyObjLog.AjouteLog(f"Des valeurs n'ont pas été sélectionnées")
    if Group == "('None')":
        Group = None
    if OS == "('None')":
        OS = None
    if Application == "('None')":
        Application = None

    Hostname = None
    Body = ""
    HostListWin = []
    HostListLin = []
    HostWin = ""
    HostLin = ""
    MaRequete = "SELECT PoolIP.IP, Servers.Hostname, Servers.UserAnsible, Servers.PassAnsible, VLAN.Public, OS.Type FROM Servers LEFT JOIN IpServer ON Servers.ID = IpServer.IDServer LEFT JOIN PoolIP ON IpServer.IDPoolIP = PoolIP.ID LEFT JOIN ServerApps ON Servers.ID = ServerApps.IdServer LEFT JOIN Applications ON Applications.ID = ServerApps.IDApplication LEFT JOIN ServerGroup ON Servers.ID = ServerGroup.IdServer LEFT JOIN Groups ON Groups.ID = ServerGroup.IdGroup LEFT JOIN VLAN ON VLAN.ID = PoolIP.IDVLAN LEFT JOIN OS ON OS.ID = Servers.IDOS"
except Exception as err :
    MyObjLog.AjouteLog(f"NOT OK Exception in {__file__} - Class:{sys._getframe().f_code.co_name} -  Erreur = {err}", MyObjLog.TopExit, True)
    raise

try :
    try :
        # Instanciation de l'objet de connexion a la base de données
        db = MaBDD.mysqlconnector()
        # Permet d'avoir les Serveurs d'un Groupe en particulier
        if Group != None and OS == None and Application == None:
            MaRequete = f"{MaRequete} WHERE Groups.ID IN {Group} AND Servers.Deleted = 0 AND IpServer.Deleted = 0 AND PoolIP.Deleted = 0 ORDER BY Servers.Hostname, VLAN.Public"
        elif Group == None and OS != None and Application == None : 
            MaRequete = f"{MaRequete} WHERE OS.ID IN {OS} AND Servers.Deleted = 0 AND IpServer.Deleted = 0 AND PoolIP.Deleted = 0 ORDER BY Servers.Hostname, VLAN.Public"
        elif Group == None and OS == None and Application != None : 
            MaRequete = f"{MaRequete} WHERE AND Applications.ID IN {Application} AND Servers.Deleted = 0 AND IpServer.Deleted = 0 AND PoolIP.Deleted = 0 ORDER BY Servers.Hostname, VLAN.Public"
        elif Group != None and OS == None and Application != None : 
            MaRequete = f"{MaRequete} WHERE Groups.ID IN {Group} AND Applications.ID IN {Application} AND Servers.Deleted = 0 AND IpServer.Deleted = 0 AND PoolIP.Deleted = 0 ORDER BY Servers.Hostname, VLAN.Public"
        elif Group == None and OS != None and Application != None : 
            MaRequete = f"{MaRequete} WHERE OS.ID IN {OS} AND Applications.ID IN {Application} AND Servers.Deleted = 0 AND IpServer.Deleted = 0 AND PoolIP.Deleted = 0 ORDER BY Servers.Hostname, VLAN.Public"
        # Execution de la requête qui va récupérer les Serveurs qui appartiennent au Groupe demandé
        Hosts_Informations = MaBDD.SelectRow(db, MaRequete)
        # Vérification que le retour de la requête n'est pas vide
        if Hosts_Informations:
            MyObjLog.AjouteLog(f"OK - Récupération des informations pour créer le fichier inventory.yaml : {Hosts_Informations}", MyObjLog.TopExit, True)
            # On boucle sur la liste que l'on vient de récupérer afin de créer notre fichier group.yaml
            for Host in Hosts_Informations : 
                # Si le hostname est le même que le précédent il faut le skip
                # Ce procédé est provosoire mais peut rester tel quel
                if Host[1] != Hostname :
                    # Déchiffrement du mot de passe
                    Password = MonAnsibleSecurity.Decrypt_Password(Host[3], MonAnsibleSecurity.GetSalt())
                    if Host[5] == 'windows':
                        HostListWin.append(Host[1])
                        # Création du contenue du fichier pour windows
                        Body = f"[{Host[1]}]\n{Host[0]}\n\n[{Host[1]}:vars]\nansible_user={Host[2]}\nansible_password={Password}\nansible_port=5986\nansible_connection=winrm\nansible_winrm_transport=basic\nansible_winrm_server_cert_validation=ignore\n\n{Body}\n"
                    else:
                        HostListLin.append(Host[1])
                        # Création du contenue du fichier pour linux
                        Body = f"[{Host[1]}]\n{Host[0]}\n\n[{Host[1]}:vars]\nansible_user={Host[2]}\nansible_password={Password}\n\n{Body}\n"
                # Attribution du Hostname a une variable pour vérifier que l'on écrit pas les même informations deux fois dans le fichier
                Hostname = Host[1]
            # Création du nom du fichier et création de ce dernier
            myfullname = "inventory.yaml"
            MonFichier = open(myfullname, 'w')
            MonFichier.write("\n" + Body)
        else:
            MyObjLog.AjouteLog(f"NOT OK - Echec de la récupération des informations pour créer le fichier inventory.yaml", MyObjLog.TopExit, True)
            raise mysql.connector.errors.Error(f"NOT OK - Echec de la récupération des informations pour créer le fichier inventory.yaml")

        #Création du playbook
        for Host in HostListLin:
            HostLin += f"{Host},"
        for Host in HostListWin:
            HostWin += f"{Host},"
        Commande_Info = MaBDD.SelectRow(db, f"SELECT IDOS, Commande, Libelle FROM Commande_OS INNER JOIN Commande on Commande.ID = {IDCommandeAnsible} WHERE IDCMD = {IDCommandeAnsible}")
        print(Commande_Info)
        
        if HostLin and not HostWin :
            BodyLin = f"---\n- hosts: {HostLin}\n  tasks:\n    - name: {Commande_Info[0][2]}\n      shell: {Commande_Info[0][1]}\n      register: resultat_commande\n\n    - name : Afficher le stdout\n      debug:\n        var: resultat_commande.stdout"
            myfullname = "playbook.yaml"
            MonFichier = open(myfullname, 'w')
            MonFichier.write("\n" + BodyLin)

        elif HostWin and not HostLin :
            BodyWin = f"---\n- hosts: {HostLin}\n  tasks:\n    - name: {Commande_Info[0][2]}\n      win_command: {Commande_Info[0][1]}\n      register: resultat_commande\n\n    - name : Afficher le stdout\n      debug:\n        var: resultat_commande.stdout"
            myfullname = "playbook.yaml"
            MonFichier = open(myfullname, 'w')
            MonFichier.write("\n" + BodyWin)

        elif HostLin and HostWin :
            BodyLin = f"---\n- hosts: {HostLin}\n  tasks:\n    - name: {Commande_Info[0][2]}\n      shell: {Commande_Info[0][1]}\n      register: resultat_commande\n\n    - name : Afficher le stdout\n      debug:\n        var: resultat_commande.stdout"
            BodyWin = f"---\n- hosts: {HostLin}\n  tasks:\n    - name: {Commande_Info[0][2]}\n      win_command: {Commande_Info[0][1]}\n      register: resultat_commande\n\n    - name : Afficher le stdout\n      debug:\n        var: resultat_commande.stdout"
            myfullname = "playbook.yaml"
            MonFichier = open(myfullname, 'w')
            MonFichier.write("\n" + BodyLin + "\n" + BodyWin)

    except (mysql.connector.errors.Error) as err:
        MyObjLog.AjouteLog(f"NOT OK Exception in {__file__} - Class:{sys._getframe().f_code.co_name} -  Erreur = {err}" , MyObjLog.TopExit, True)
        raise
except Exception as err :
    MyObjLog.AjouteLog(f"NOT OK Exception in {__file__} - Class:{sys._getframe().f_code.co_name} -  Erreur = {err}", MyObjLog.TopExit, True)
    raise