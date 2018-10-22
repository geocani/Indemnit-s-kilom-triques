<?php
    if (isset($_POST['send-trajet'])){
        // Nomination variable POST
        $date_trajet = $_POST['date-trajet'];
        $heure_administrative = $_POST['heure-administrative'];
        $heure_domicile = $_POST['heure-domicile'];
        $nom_commune = $_POST['nom-commune'];
        $heure_arrivee = $_POST['heure-arrivee'];
        $heure_depart = $_POST['heure-depart'];
        $fin_mission = $_POST['fin-mission'];
        $km_aglomeration = $_POST['km-aglomeration'];
        $km_hors = $_POST['km-hors'];
        $transport = $_POST['transport'];
        $motif = $_POST['motif'];


        // SANITISATION

            // Verificatation
            if(!empty($date_trajet)){
                if(!empty($heure_administrative) OR !empty($heure_domicile)){
                    if(!empty($nom_commune)){
                        if(!empty($heure_arrivee)){
                            if(!empty($heure_depart)){
                                if(!empty($fin_mission)){
                                    if(!empty($km_aglomeration)){
                                        if(!empty($km_hors)){
                                            if(!empty($motif)){
                                                if(!empty($_POST['cert1']) AND !empty($_POST['cert2'])){
                                                    // Ecrire dans la BDD
                                                    $insert_trajet = $bdd->prepare("INSERT INTO trajets(id_agent, date_trajet, heure_administrative, heure_domicile, nom_commune, heure_arrivee, heure_depart, fin_mission, km_aglomeration, km_hors, transport, motif, status_trajet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                                    $insert_trajet->execute(array($_SESSION['id_agent'], $date_trajet, $heure_administrative, $heure_domicile, $nom_commune, $heure_arrivee, $heure_depart, $fin_mission, $km_aglomeration, $km_hors, $transport, $motif, "En cours"));
                                                    // Redirection
                                                    header("location: historique.php?id=".$_SESSION['id_agent']);
                                                }else{
                                                    $erreur_cert = "erreur certif";
                                                }
                                            }else{
                                                $erreur_motif = "erreur motif";
                                            }
                                        }else{
                                            $erreur_hors = "erreur hors";
                                        }
                                    }else{
                                        $erreur_aglo = "erreur aglo";
                                    }
                                }else{
                                    $erreur_mission = "erreur MISSION";
                                }
                            }else{
                                $erreur_depart = "ERREUR DEPART";
                            }
                        }else{
                            $erreur_arrivee = "ERREUR ARRIVEE";
                        }
                    }else{
                        $erreur_commune = "* Entrez le nom de la commune visitée";
                    }
                }else{
                    $erreur_heure = "* Veuillez entrer une heure de départ";
                }
            }else{
                $erreur = "* Ce champ est obligatoire";
            }
    }
?>




<!--MAIN-->
<section id="main-content">
    <section class="wrapper">
        <!-- FORM -->
        <div class="container form-frais">
            <div class="titre-page">
                <h2><i class="fa fa fa-car pad-ico-profil"></i><span> CREATION DE TRAJET</span><h2>
                <?php
                    if(isset($ok)){
                        echo $ok;
                    }
                ?>
            </div>
            <form action="" method="POST">
                <!--Date et heure de départ-->
                <h4>Date et heure de départ.</h4>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="date-trajet">Date:</label>
                        <input type="date" name="date-trajet" class="form-control" id="date-trajet" placeholder="Heure">
                        <div class="erreur">
                            <?php if(isset($erreur)){echo $erreur;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="heure-administrative">Départ résidence administrative:</label>
                        <input type="time" name="heure-administrative" class="form-control" id="heure-administrative" placeholder="résidence administrative">
                        <div class="erreur">
                            <?php if(isset($erreur_heure)){echo $erreur_heure;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="heure-domicile">Départ domicile:</label>
                        <input type="time" name="heure-domicile" class="form-control" id="heure-domicile" placeholder="Domicile">
                    </div>
                </div>
                <!--Commune visitée-->
                <h4>Commune visitée.</h4>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="nom-commune">Nom:</label>
                        <input type="text" name="nom-commune" class="form-control" id="nom-commune" placeholder="Ex: Namur">
                        <div class="erreur">
                            <?php if(isset($erreur_commune)){echo $erreur_commune;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="heure-arrivee">Heure d'arrivée:</label>
                        <input type="time" name="heure-arrivee" class="form-control" id="heure-arrivee" placeholder="">
                        <div class="erreur">
                            <?php if(isset($erreur_arrivee)){echo $erreur_arrivee;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="heure-depart">Heure de retour:</label>
                        <input type="time" name="heure-depart" class="form-control" id="heure-depart" placeholder="">
                        <div class="erreur">
                            <?php if(isset($erreur_depart)){echo $erreur_depart;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fin-mission">Heure de fin de mission:</label>
                        <input type="time" name="fin-mission" class="form-control" id="fin-mission" placeholder="">
                        <div class="erreur">
                            <?php if(isset($erreur_mission)){echo $erreur_mission;}?>
                        </div>
                    </div>
                </div>
                <!--KM parcourus-->
                <h4>Kilomètres parcourus.</h4>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="km-aglomeration">Dans l'agomération:</label>
                        <input type="number" name="km-aglomeration" class="form-control" id="km-aglomeration" placeholder="Ex: 10" step="0.01">
                        <div class="erreur">
                            <?php if(isset($erreur_aglo)){echo $erreur_aglo;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="km-hors">Hors aglomération:</label>
                        <input type="number" name="km-hors" class="form-control" id="km-hors" placeholder="Ex: 10" step="0.01">
                        <div class="erreur">
                            <?php if(isset($erreur_hors)){echo $erreur_hors;}?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="transport">Transport en commun:</label>
                        <input type="number" name="transport" class="form-control" id="transport" placeholder="Ex: 2,50" step="0.01" Value="0">
                        <div class="erreur">
                            <?php if(isset($erreur_transport)){echo $erreur_transport;}?>
                        </div>
                    </div>
                </div>
                <!--Séjours-->
                <!-- <h4>Séjours.</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="transport">Temps de séjours:</label>
                        <select class="form-control">
                            <option>Sélectionner une durée</option>
                            <option>+ 5h à - 8h</option>
                            <option>8h et plus</option>
                            <option>Nuitées</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="transport">Frais réels limités au plafond:</label>
                        <input type="number" name="transport" class="form-control" id="transport" placeholder="Ex: 2,50" step="0.01">
                    </div>
                </div> -->
                <!--Motif-->
                <div class="form-group">
                    <label for="motif">Motif:</label>
                    <textarea class="form-control" name="motif" id="motif" rows="3"></textarea>
                    <div class="erreur">
                        <?php if(isset($erreur_motif)){echo $erreur_motif;}?>
                    </div>
                </div>
                <!--certification-->
                <div class="form-group">
                    <div class="form-check">
                        <p>
                            <input class="form-check-input" name="cert1" type="checkbox" id="certif1">
                            <label class="form-check-label" for="certif1">Je déclare de ne pas bénéficier d'un libre parcours et/ou de bénéficier d'une rédution sur les chemins de fer et autobus.</label>
                        </p>
                        <p>
                            <input class="form-check-input" name="cert2" type="checkbox" id="certif2">
                            <label class="form-check-label" for="certif2">J'affirme sur l'honneur que cette déclaration est sincère et complète à la somme de quarante et un euro, dix-huit cents.</label>
                        </p>
                    </div>
                    <div class="erreur">
                        <?php if(isset($erreur_cert)){echo $erreur_cert;}?>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="send-trajet" value="Envoyer le formulaire">
            </form>
        </div>
    </section>
</section>