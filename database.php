<?php 
/* Si on a accès à la bdd*/
define('host', 'localhost'); 
define('dbname', 'Projet_Transvers2.0');
define('user', 'root');
define('pwd', '');
try{
    /*nom de la base de donnée*/
    //vérifier le host
    $bdd = new PDO("mysql:host=" . host .";dbname=" . dbname, user, pwd);
    $bdd -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo $e;
}
