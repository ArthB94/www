<!DOCTYPE html>
<html lang="fr">
<!-- L'en-tête -->

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Ajouter un ustensile</title>
    <link rel="stylesheet" href="styles/Styles.css">
    <script type="text/javascript" src="../JS/data.js"></script>
</head>

<!-- Le corps-->

<body>
    <?php include "database.php";
    global $bdd;
    $email = "Admin@gmail.com";
    ?>
    <form method="post" action="Ajouter_ustensile">
        <table>
            <thead>
                <tr>
                    <td><strong>Nom de l'ustensile:</strong></td>
                    <td><strong>Type:</strong></td>
                    <td><strong>Prix par unité:</strong></td>


                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="ustensile" size="25" placeholder="Nom de l'ustensile" required></td>
                    <td><select id="Utype" name="Utype" size=1></select></td>
                    <td><input type="number" name="prix" size="25" placeholder="prix" min="0.01" max="10000" step="0.01" required><strong>€/u</strong></td>
                </tr>
            </tbody>
            <thead>
                <td colspan="3"><strong>Description:</strong></td>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3"><textarea style="width: 980px; height: 300px;" name="description" placeholder="Description"></textarea></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" name="formsend" value="Ajouter" /></textarea></td>
                </tr>
            </tbody>


        </table>


    </form>
    <?php
    if (isset($_POST['formsend'])) {

        echo 'envoyé';

        $creatIng = $bdd->prepare("INSERT INTO ustensile(Nom,description,Utype,prix,email) VALUES (:Nom,:description,:Utype,:prix,:email)");
        $creatIng->execute([
            'Nom' => $_POST['ustensile'],
            'description' => $_POST['description'],
            'Utype' => $_POST['Utype'],
            'prix' => $_POST['prix'],
            'email' => $email

        ]);
    }

    ?>

    <footer>
        <a href="Affichage_ustensiles.php"> Voir les ustensiles </a>
        <br>
        <a href="index.php"> Revenir à l'accueil </a>
        <br>
    </footer>
    <script type="text/javascript" src="../JS/script.js"></script>
</body>

</html>