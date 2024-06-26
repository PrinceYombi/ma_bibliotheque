<?php
session_start();
require_once ("include.php");
verifParams();

/**
 * GESTION DES REQUETTES
 */
if (!isset($_SERVER['PATH_INFO'])) {
    $_SERVER['PATH_INFO'] = "accueil";

}
if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/categorie/livre") {
    
    $_SERVER['PATH_INFO'] = "livre";
}
//print_r($_SERVER['PATH_INFO']); exit();

$_SERVER['PATH_INFO'] = trim($_SERVER['PATH_INFO'], "/");
$url = explode("/",$_SERVER['PATH_INFO']);


$action = $url[0];

//URL
$root = array(
"accueil", "categorie", "livre", "addLivre", "addLivreAction", "retour", "supprimerBook", "voirBook", "user","supprimerUser", "addUser", "addUserAction",
"voirUser", "createCount", "loginAdmin", "loginUser", "deconnexion", "actionInscription", "profil", "updateProfil",
"updateProfilAction", "empruntAction", "rendreBookEmprunt", "rechercheBook", "emprunt"
);

/**
 * VERIFICATION URL
 */
if (!in_array($action, $root)) {
    $title = "Error";
    $content = "URL introuvable";
}else{
    $title = "Page ".$action;
    $funtion = "display".($action);
    $content = $funtion();
}

//LA VUE
require_once VIEW.SP."view.php";

?>