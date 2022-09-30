<!DOCTYPE html>
<html lang="fr">
<!-- L'en-tête -->

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Ajouter un ingrédient</title>
    <link rel="stylesheet" href="styles/Styles.css">
    <script type="text/javascript" src="../JS/data.js"></script>
    <script type="text/javascript" src="../JS/script.js"></script>
</head>

<!-- Le corps-->

<body>
    <?php include "database.php";
    global $bdd;
    $ids = $bdd->query("SELECT ID_ingredients FROM ingredient ");
    $numID = 0;
    $email = "Admin@gmail.com";

    while ($id = $ids->fetch()) {
        if ($numID < (int) filter_var($id['ID_ingredients'], FILTER_SANITIZE_NUMBER_INT)) {
            $numID  =  (int) filter_var($id['ID_ingredients'], FILTER_SANITIZE_NUMBER_INT);
        }
    } ?>
    <form method="post">

        <h3>Nom de l'ingrédient:</h3>
        <input type="text" name="ingrédient" size="25" placeholder="Nom de l'ingrédient" required>


        <h3>Type:</h3>
        <select name="Itype" id="Itype" size=1 onclick="console.log(this)" onchange="remplir_déroul('unité', listeUnité(this.value))">
        </select>


        <h3>Prix par unité:</h3>
        <input type="number" name="prix" min="0.05" max="1000" step="0.05" size="25" placeholder="quantité" required>
        <h3>€/</h3>

        <select id="unité" size=1>
        </select>


        <input type="submit" name="formsend" value="Ajouter" />
    </form>
    <?php
    if (isset($_POST['formsend'])) {
        echo "envoyé";
        $creatIng = $bdd->prepare("INSERT INTO ingredient(ID_Ingredients,Itype,Nom,Prix,email) VALUES (:ID_Ingredients,:Itype,:Nom,:Prix,:email)");
        $creatIng->execute([
            'ID_Ingredients' => "Ingr" . ($numID + 1),
            'Itype' => $_POST['Itype'],
            'Nom' => $_POST['ingrédient'],
            'Prix' => $_POST['prix'],
            'email' => $email

        ]);
    } ?>
    <footer>
        <a href="Affichage_Ingrédients.php"> Voir les ingrédients </a>
        <br>
        <a href="index.php"> Revenir à l'accueil </a><br>
    </footer>
    <script type="text/javascript" src="../JS/script.js"></script>
</body>

</html>