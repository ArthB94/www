<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Modifier recette</title>
    <link rel="stylesheet" href="styles/Styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="../JS/data.js"></script>
    <script type="text/javascript" src="../JS/class.js"></script>
    <script type="text/javascript" src="../JS/script.js"></script>



</head>

<?php try {

    /* récuperation de la recette */
    include 'database.php';
    global $bdd;
    $ID_recette = $_GET['v1'];

    $Recette = $bdd->query("SELECT * FROM recette WHERE ID_recette = '$ID_recette'");
    $email = "Admin@gmail.com";


    //-----------remplire dérouliste ---------
    $SELECTI = $bdd->query("SELECT * FROM ingredient ");
    $SELECTU = $bdd->query("SELECT * FROM ustensile ");
    $i = 0;
    $Ings = [];
?>
    <script>
        var Ings = new Array(<?php
                                $i = 0;
                                while ($Ing = $SELECTI->fetch()) {
                                    $i++;
                                    array_push($Ings, $Ing);
                                ?>new Ingrédient(<?php echo '"' . $Ing['ID_ingredients'] . '"' . ',' . '"' . $Ing['Itype'] . '"' . ',' . '"' . $Ing['Nom'] . '"' . ',' . '"' . $Ing['Prix'] . '"' . ',' . '"' . $Ing['email'] . '"' ?>), <?php } ?>)


        var Usts = new Array(<?php
                                $i = 0;
                                while ($Ust = $SELECTU->fetch()) {
                                    $i++
                                ?>new Ustensile(<?php echo '"' . $Ust['Utype'] . '"' . ',' . '"' . $Ust['Nom'] . '"' . ',' . '"' . $Ust['description'] . '"' . ',' . '"' . $Ust['prix'] . '"' . ',' . '"' . $Ust['email'] . '"' ?>), <?php } ?>)
    </script>

    <!-- Le corps-->

    <body onload="remplir_déroul('unité', listeUnité('Tous'));remplir_déroul('Ingr', Liste_arg(Liste_Type(Ings,'Tous'),'Nom'));remplir_déroul('Ust', Liste_arg(Liste_Type(Usts,'Tous'),'Nom'))">

        <h1>Modifier votre recette</h1>
        </br>
        <?php while ($Rec = $Recette->fetch()) { ?>
            <!----- Infos de la recette  -->
            <form method="post">

                <strong>Nom de la recette:</strong>
                <input type="text" name="recette" size="25" placeholder="Nouvelle recette" value='<?php echo $Rec["Nom_recette"] ?>' required>
                <strong>Temps de préparation:</strong>
                <input type="time" name="temps" size="5" value='<?php echo $Rec["temps_de_preparation"] ?>' required>
                <strong>Nombre de personnes:</strong>
                <input type="number" name="nb_pers" size="5" value='<?php echo $Rec["Nb_personnes"] ?>' min="1" max="100" required>
                </br>
                </br>
                </br>
                <textarea cols="60" rows="8" name="desc" maxlength="5000" placeholder="Description"><?= $Rec["description"]  ?></textarea>
                </br>


                <!-- ingrédients de la recette-->

                <!-- Ajout d'ingrédients -->


                <strong>Type:</strong>
                <select id="Itype" name="Itype" size=1 onchange="remplir_déroul('unité', listeUnité(this.value));remplir_déroul('Ingr', Liste_arg(Liste_Type(Ings,this.value),'Nom')) ">
                    <option>Tous</option>
                </select>
                <strong>Ingrédient : </strong>

                <select name="Ingr" id="Ingr" size=1 required>
                </select>

                <input type="number" name="qttI" id="qttI" size="25" min="0.05" max="999" step="0.05" placeholder="quantité" value="1" required>

                <select id="unité" name="unité" ize=1 required>
                    <option>unité</option>
                </select>
                <br />

                <button type="button" class="btn" onclick="ajouterIng()">Ajouter</button>
                <button type="button" onclick="window.location.href = 'Ajouter_ingrédient.php';">Ajouter un Ingrédient</button>


                <!-- affichage ingrédients de la recette-->

                <table id="datatableI" nom="datatableI" class="datatable">
                    <thead>
                        <tr>
                            <td><strong> Ingrédient</strong></td>
                            <td><strong> Quantité</strong></td>
                            <td><strong> Unité</strong></td>
                            <td><button type="button" class="btn" onclick="supprimerIngs()">Vider la liste</button></td>
                        </tr>
                    </thead>



                    <tbody>
                        <?php
                        $LastCont_Ing = $bdd->query("SELECT * FROM contenir_ingredient WHERE ID_recette = '$ID_recette'");
                        $cpt = 1;
                        while ($cont_Ing = $LastCont_Ing->fetch()) { ?>
                            <tr>
                                <?php $Ing = $bdd->query("SELECT * FROM ingredient WHERE ID_ingredients = " . "'" . $cont_Ing["ID_ingredients"] . "'")->fetch(); ?>
                                <td><input name="<?= $cpt ?>inputIngr" type="text" value='<?= $Ing["Nom"]  ?>' readonly></td>
                                <td><input name="<?= $cpt ?>inputqtt" type="text" value="<?= $cont_Ing["Quantite"] ?>" readonly></td>
                                <td><input name="<?= $cpt ?>inputunité" type="text" value="<?= $cont_Ing["Unite"] ?>" readonly></td>
                                <td><button type="button" onclick="suprIng(this)">supprimer</button></td>
                            </tr>
                        <?php $cpt += 1;
                        } ?>
                    </tbody>
                </table>


                <!-- Ustensiles de la recette-->


                <!--Ajout d'ustensile-->

                <strong>Type:</strong>
                <select name="Utype" id="Utype" size=1 onchange="remplir_déroul('Ust', Liste_arg(Liste_Type(Usts,this.value),'Nom'))">
                    <option>Tous</option>
                </select>

                <strong>Ustensile : </strong>
                <select name="Ust" id="Ust" size=1required>
                </select>

                <input type="number" name="qttU" id="qttU" size="25" placeholder="quantité" value=1 required>
                <br />

                <button type="button" class="btn" onclick="ajouterUst()">Ajouter</button>
                <button type="button" onclick="window.location.href = 'Ajouter_ustensile.php';">Ajouter un ustensile</button>


                <!--Affichage ustensiles-->

                <table id="datatableU" class="datatable">
                    <thead>
                        <tr>
                            <td><strong> Outil</strong></td>
                            <td><strong> Quantité</strong></td>
                            <td><button type="button" class="btn" onclick="supprimerUst()">Vider la liste</button></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $LastNec_Us = $bdd->query("SELECT * FROM necessiter WHERE ID_recette = '$ID_recette' ");
                        $cpt = 1;
                        while ($Nec_Us = $LastNec_Us->fetch()) { ?>
                            <tr>
                                <?php $Us = $bdd->query("SELECT * FROM ustensile WHERE Nom = " . "'" . $Nec_Us["Nom"] . "'")->fetch(); ?>
                                <td><input type="text" name="<?= $cpt ?>inputUst" value='<?= $Us["Nom"]  ?>' readonly></td>
                                <td><input type="text" name="<?= $cpt ?>inputUqtt" value="<?= $Nec_Us["Nombre"] ?>" readonly></td>
                                <td><button type="button" onclick="suprUst(this)">supprimer</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


                <input type="submit" name="Ajout_Recette" value="Ajouter recette" />
                <input type="submit" name="Supprim_recette" value="Suppimer recette" />

            </form>

            <?php
            if (isset($_POST['Supprim_recette'])) {
                $bdd->query("DELETE  FROM recette WHERE ID_recette =" . "'" . $ID_recette . "'");
                $bdd->query("DELETE  FROM contenir_ingredient WHERE ID_recette =" . "'" . $ID_recette . "'");
                $bdd->query("DELETE  FROM necessiter WHERE ID_recette =" . "'" . $ID_recette . "'");
                echo "Supprimé";
                echo "<script>window.location.href = 'Affichage_recette.php'</script>";
            }

            if (isset($_POST['Ajout_Recette'])) {
                $bdd->query("DELETE  FROM recette WHERE ID_recette =" . "'" . $ID_recette . "'");
                $bdd->query("DELETE  FROM contenir_ingredient WHERE ID_recette =" . "'" . $ID_recette . "'");
                $bdd->query("DELETE  FROM necessiter WHERE ID_recette =" . "'" . $ID_recette . "'");
                $creatRecette = $bdd->prepare("INSERT INTO recette(ID_recette,Nom_recette,description,temps_de_preparation,Nb_personnes,email) VALUES (:ID_recette,:Nom_recette,:description,:temps_de_preparation,:Nb_personnes,:email)");
                $creatRecette->execute([
                    'ID_recette' => $ID_recette,
                    'Nom_recette' => $_POST['recette'],
                    'description' => $_POST['desc'],
                    'temps_de_preparation' => $_POST['temps'],
                    'Nb_personnes' => $_POST['nb_pers'],
                    'email' => $email

                ]);

                $i = 1;
                $id_ing = 0;
                while (isset($_POST[$i . 'inputIngr'])) {
                    foreach ($Ings as &$Ing) {
                        if (($Ing['Nom']) ==  ($_POST[$i . 'inputIngr'])) {
                            $id_ing = $Ing['ID_ingredients'];
                        }
                    }
                    $creatCont = $bdd->prepare("INSERT INTO contenir_ingredient(ID_ingredients,ID_recette,Quantite,Unite) VALUES (:ID_ingredients,:ID_recette,:Quantite,:Unite)");
                    $creatCont->execute([
                        'ID_ingredients' => $id_ing,
                        'ID_recette' => $ID_recette,
                        'Quantite' => $_POST[$i . 'inputqtt'],
                        'Unite' => $_POST[$i . 'inputunité']
                    ]);
                    $i++;
                }
                $c = 1;
                while (isset($_POST[$c . 'inputUst'])) {
                    $creatCont = $bdd->prepare("INSERT INTO necessiter(Nom,ID_recette,Nombre) VALUES (:Nom,:ID_recette,:Nombre)");
                    $creatCont->execute([
                        'Nom' => $_POST[$c . 'inputUst'],
                        'ID_recette' => $ID_recette,
                        'Nombre' => $_POST[$c . 'inputUqtt']
                    ]);
                    $c++;
                }
                echo "envoyé";
                echo "<script>window.location.href = 'Affichage_recette.php'</script>";
            }

            ?>
    <?php }
    } catch (PDOException $e) {
        echo $e;
    } ?>

    <footer>

        <a href="Ajouter_recette.php">Ajouter une recette</a></br>
        <a href="index.php"> Revenir à l'accueil </a><br>

    </footer>

    <script type="text/javascript" src="../js/script.js"></script>
    </body>

</html>