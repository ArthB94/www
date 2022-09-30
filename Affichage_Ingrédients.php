<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Mes ingrédients</title>
  <link rel="stylesheet" href="styles/Styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="../JS/data.js"></script>

</head>

<body>
  <?php include 'database.php';
  global $bdd; ?>
  <table id="datatableAffichageI" class="datatable">
    <thead>
      <tr class="pres">
        <td>
          <h3>Type:</h3>
          <form method="post">
            <select id="Itype" name="Itype" size=1 onclick="console.log(this)" onchange="this.form.submit()">
              <?php
              if (isset($_POST['Itype']) && $_POST['Itype'] != "Tous") {

                $Itype = $_POST['Itype'];
                $Ingrédients = $bdd->query("SELECT * FROM ingredient WHERE Itype = " . "'" . $Itype . "'");
                $type1 = $_POST['Itype'];
              } else {
                $Ingrédients = $bdd->query("SELECT * FROM ingredient ");
                $type1 = "choix:";
              }

              ?>
              <option> <?php echo $type1 ?> </option>
              <option>Tous</option>
            </select>
          </form>
        </td>
        <td>
          <h1>ingrédients</h1>
        </td>
        <td><button type="button" onclick="window.location.href = 'Ajouter_ingrédient.php';">Ajouter un ingrédient</button></td>
      </tr>
    </thead>

    <tr>
      <td>
        <h3>Nom : </h3>
      </td>
      <td>
        <h3>Type : </h3>
      </td>
      <td>
        <h3>Prix à l'unité : </h3>
      </td>
    </tr>
    <?php while ($Ing = $Ingrédients->fetch()) { ?>
      <tr>
        <td><?= $Ing["Nom"]  ?></td>
        <td><?= $Ing["Itype"]  ?></td>
        <td><?= $Ing["Prix"]  ?> €</td>
      </tr>

    <?php } ?>
  </table>
  <footer>
    <a href="Ajouter_ingrédient.php"> Ajouter un ingrédient </a><br>
    <a href="index.php"> Revenir à l'accueil </a><br>
  </footer>

  <script type="text/javascript" src="../JS/script.js"></script>
</body>

</html>