<!DOCTYPE html>
<html lang="fr">
<!-- L'en-tête -->

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Ajouter une recette</title>
    <link rel="stylesheet" href="styles/Styles.css">
    <script type="text/javascript" src="../JS/data.js"></script>
    <script type="text/javascript" src="../JS/class.js"></script>
    <script type="text/javascript" src="../JS/script.js"></script>



</head>
<!-- Importer SELECT-->
<?php
include 'database.php';
global $bdd;
$ids = $bdd->query("SELECT ID_recette FROM recette ");
$numID = 0;
$email = "Admin@gmail.com";
$SELECTI = $bdd->query("SELECT * FROM ingredient ");
$SELECTU = $bdd->query("SELECT * FROM ustensile ");
$i = 0;
$Ings = [];
while ($id = $ids->fetch()) {
    if ($numID < (int) filter_var($id['ID_recette'], FILTER_SANITIZE_NUMBER_INT)) {
        $numID  =  (int) filter_var($id['ID_recette'], FILTER_SANITIZE_NUMBER_INT);
    }
} ?>
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

<body onload="remplir_déroul('unité', listeUnité('Tous'));remplir_déroul('Ingr', Liste_arg(Liste_Type(Ings,'Tous'),'Nom'));   remplir_déroul('Ust', Liste_arg(Liste_Type(Usts,'Tous'),'Nom'))">
    <!-- caractéristiques de la recette-->
    <h1>Ajoutez votre recette</h1>
    <table>
        <form method="post">
            <tr>
                <td><strong>Nom de la recette:</strong>
                    <input type="text" name="recette" size="25" placeholder="Nouvelle recette" required>
                </td>
                <td><strong>Temps de préparation:</strong>
                    <input type="time" name="temps" size="5" placeholder="min" required>
                </td>
                <td><strong>Nombre de personnes:</strong>
                    <input type="number" name="nb_pers" size="5" placeholder="pers" min="1" max="100" required>
                </td>
            </tr>
            <tr>
                <td colspan="3"><textarea style="width: 980px; height: 280px;" name="desc" maxlength="5000" placeholder="Description"></textarea></td>
            </tr>

            <!-- ingrédients de la recette-->

            <tr>
                <td><strong>Type:</strong>
                    <select id="Itype" name="Itype" size=1 onchange="remplir_déroul('unité', listeUnité(this.value));  remplir_déroul('Ingr', Liste_arg(Liste_Type(Ings,this.value),'Nom')) ">
                        <option>Tous</option>
                    </select>
                </td>
                <td>
                    <strong>Ingrédient : </strong>
                    <select name="Ingr" id="Ingr" size=1 required>
                    </select>
                    <input type="number" name="qttI" id="qttI" size="1" min="0.05" max="10000" step="0.05" placeholder="quantité" min="1" max="100" value="1" required>
                    <select id="unité" name="unité" size=1 required>
                        <option>unité</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn" onclick="ajouterIng()">Ajouter</button>
                </td>
            </tr>

            <!-- affichage ingrédients de la recette-->
            <tr>
                <td colspan="3">
                    <table id="datatableI" nom="datatableI" class="datatable">
                        <thead>
                            <tr>
                                <td><strong> Ingrédient</strong></td>
                                <td><strong> Quantité</strong></td>
                                <td><strong> Unité</strong></td>
                                <td><button type="button" class="btn" onclick="supprimerIngs()">Vider la liste</button></td>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </td>
            </tr>
            <!-- Ustensiles de la recette-->
            <tr>
                <td>
                    <strong>Type:</strong>
                    <select name="Utype" id="Utype" size=1 onchange="remplir_déroul('Ust', Liste_arg(Liste_Type(Usts,this.value),'Nom'))">
                        <option>Tous</option>
                    </select>
                </td>
                <td>
                    <strong>Ustensile : </strong>
                    <select name="Ust" id="Ust" size=1required>
                    </select>

                    <input type="number" name="qttU" id="qttU" size="25" placeholder="quantité" value=1 required>
                    <br />
                </td>
                <td>
                    <button type="button" class="btn" onclick="ajouterUst()">Ajouter</button>
                </td>

            </tr>
            <tr>
                <td colspan="3">
                    <table id="datatableU" class="datatable">
                        <thead>
                            <tr>
                                <td><strong> Outil</strong></td>
                                <td><strong> Quantité</strong></td>
                                <td><button type="button" class="btn" onclick="supprimerUst()">Vider la liste</button></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" name="formsend" value="Ajouter recette" />
                </td>
            </tr>
        </form>

        <?php
        if (isset($_POST['formsend'])) {

            $creatRecette = $bdd->prepare("INSERT INTO recette(ID_recette,Nom_recette,description,temps_de_preparation,Nb_personnes,email) VALUES (:ID_recette,:Nom_recette,:description,:temps_de_preparation,:Nb_personnes,:email)");
            $creatRecette->execute([
                'ID_recette' => "recette" . ($numID + 1),
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
                    'ID_recette' => "recette" . ($numID + 1),
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
                    'ID_recette' => "recette" . ($numID + 1),
                    'Nombre' => $_POST[$c . 'inputUqtt']
                ]);
                $c++;
            }
            echo "envoyé";
        }

        ?>
    </table>
    <footer>
        <a href="Affichage_recette.php"> Voir les recettes </a>
        </br>
        <a href="index.php"> Revenir à l'accueil </a>
        </br>
    </footer>

    <script type="text/javascript" src="../JS/script.js"></script>

</body>

</html>