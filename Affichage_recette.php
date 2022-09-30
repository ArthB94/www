<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Mes recettes</title>
    <link rel="stylesheet" href="styles/Styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="../JS/data.js"></script>


</head>

<body>
    <?php include 'database.php';
    global $bdd; ?>
    <h1>Recettes</h1>
    </br>

    <table id="datatableAffichageI" class="datatable">
        <thead>
            <tr class="pres">
                <td>
                    <h3>Nom : </h3>
                </td>
                <td>
                    <h3>Description : </h3>
                </td>
                <td>
                    <h3>Temps de préparation : </h3>
                </td>
                <td>
                    <h3>Ingrédients : </h3>
                </td>
                <td>
                    <h3>Ustenciles : </h3>
                </td>
                <td>
                    <h3><button type="button" onclick="window.location.href = 'Ajouter_recette.php';">Ajouter une recette</button></h3>
                </td>
            </tr>
        </thead>

        <tbody>
            <?php
            $Recettes = $bdd->query("SELECT * FROM recette ");
            while ($Rec = $Recettes->fetch()) {
            ?>

                <tr <?php echo "id = 1" ?>>

                    <td>
                        <h4><?= $Rec["Nom_recette"]; ?></h4>
                    </td>
                    <td><?= $Rec["description"]  ?></td>
                    <td><?= $Rec["temps_de_preparation"] ?></td>
                    <td>
                        <?php
                        $cont_Ings = $bdd->query("SELECT * FROM contenir_ingredient WHERE ID_recette = " . "'" . $Rec["ID_recette"] . "'");
                        while ($cont_Ing = $cont_Ings->fetch()) {
                            $Ing = $bdd->query("SELECT * FROM ingredient WHERE ID_ingredients = " . "'" . $cont_Ing["ID_ingredients"] . "'")->fetch(); ?>
                            <p><?= $Ing["Nom"]  ?></p>
                            <p><?= $cont_Ing["Quantite"] ?> <?= $cont_Ing["Unite"] ?></p>
                        <?php } ?>
                    </td>

                    <td>
                        <?php
                        $nec_Us = $bdd->query("SELECT * FROM necessiter WHERE ID_recette = " . "'" . $Rec["ID_recette"] . "'");
                        while ($necessiter = $nec_Us->fetch()) {
                            $Ust = $bdd->query("SELECT * FROM ustensile WHERE Nom = " . "'" . $necessiter["Nom"] . "'")->fetch(); ?>
                            <p><?= $necessiter["Nombre"] ?> <?= $Ust["Nom"]  ?></p>
                        <?php } ?>
                    </td>
                    <td>
                        <script>
                            <?php echo $Rec['ID_recette'] ?> = <?php echo '"' . $Rec["ID_recette"] . '"' ?>
                        </script>

                        <button type="button" onclick="window.location.href='Modifier_recette.php?v1=<?php echo $Rec['ID_recette'] ?>'" ;> modifier </button>
                    </td>

                </tr>
            <?php } ?>
        </tbody>

    </table>


    <footer>
        <a href="Ajouter_recette.php">Ajouter une recette</a>
        </br>
        <a href="index.php"> Revenir à l'accueil </a>
        <br>
    </footer>

    <script type="text/javascript" src="../js/script.js"></script>
</body>

</html>