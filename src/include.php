<?php
/**
 * LES CONSTANTES
 */
define("ROOT", dirname(__DIR__));
define("SP", DIRECTORY_SEPARATOR);
define("VIEW", ROOT.SP."view");
define("MODEL", ROOT.SP."model");
define("BASE_URL", dirname(dirname($_SERVER['SCRIPT_NAME'])));

require_once ROOT.SP."src".SP."functions.php";
require_once MODEL.SP."dataLayer.model.php";
require_once MODEL.SP."config".SP."config.php";

/**
 * LE MODEL
 */
$model = new dataLayer();
$categorie = $model->getCategorie();

?>