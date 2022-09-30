<!doctype html>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <title>Mes ustensiles</title>
    <link rel= "stylesheet" href= "styles/Styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="../JS/data.js"></script>

  </head>

  <body>

    <?php include 'database.php';global $bdd;?>
    <table id="datatableAffichageI" class="datatable">
      <thead>
        <tr class="pres">
          <td>            
            <h3>Type:<h3>
            <form method="post">
              <select id="Utype" name="Utype" size=1 onclick="console.log(this)" onchange="this.form.submit()">
                <?php
                if (isset($_POST['Utype']) && $_POST['Utype']!= "Tous"){
                    echo "envoyé";
                    $Utype= $_POST['Utype'];
                    $Ustensile= $bdd->query("SELECT * FROM ustensile WHERE Utype = "."'".$Utype."'" );
                    $type1=$_POST['Utype']; 
                  } 
                else{
                    $Ustensile= $bdd->query("SELECT * FROM ustensile " );
                    $type1= "choix:";
                }
                ?>
                <option> <?php echo $type1 ?> </option>
                <option>Tous</option>
              </select>

            </form></td>
          <td></td>
          <td></td>
          <td><h3><button type="button" onclick= "window.location.href = 'Ajouter_ustensile.php';">Ajouter un ustensile</button></h3></td>  

        </tr>
      </thead>

      <tbody>
        <tr><td><strong>Nom : </strong></td> <td><strong>Type : </strong></td><td><strong>Description : </strong></td> <td><strong>Prix: </strong></td>
        <?php while($Ust=$Ustensile->fetch()){ ?>
          <tr>
              <td><h4><?=$Ust["Nom"]  ?></h4></td>
              <td><?=$Ust["Utype"]  ?></td>
              <td><?=$Ust["description"] ?> </td>
              <td><?=$Ust["prix"]  ?> €</td>
          </tr>
        <?php }?>      
      </tbody>

    </table>
      <footer>
        <a href = "Ajouter_ustensiles"> Ajouter un ustensile </a>
        </br>
        <a href = "index.php"> Revenir à l'accueil </a><br>
      </footer>

      <script type="text/javascript" src="../JS/script.js"></script>
    </body>

  </html>