<?php

//bestellen.php

use Business\GebruikerService;
use Business\BelegService;
use Business\TypeService;
use Business\BroodjeService;
require_once("Business/GebruikerService.php");
require_once("Business/BelegService.php");
require_once("Business/TypeService.php");
require_once("Business/BroodjeService.php");

$gebruikerSvc = new GebruikerService();
$gebruiker = $gebruikerSvc->getIngelogdeGebruiker();
if ($gebruiker) {
    $naamGebruiker = $gebruiker->getVoornaam();
    $gebruikersId = $gebruiker->getId();

    $belegSvc = new BelegService();
    $tabBeleg = $belegSvc->getBelegOverzicht();

    $typeSvc = new TypeService();
    $tabType = $typeSvc->getTypeOverzicht();

    $broodjeSvc = new BroodjeService();
}

if (!$gebruiker) {
    //niet ingelogd: verwijzen naar inlogform
    header("location: inloggen.php"); 
    exit(0);
} elseif ($broodjeSvc->getBroodjesByGebruikerVandaag($gebruikersId) && !isset($_POST["bestelextra"])) {
    //reeds besteld: toon overzicht
    header("location: toonbesteldebroodjes.php?error=reedsbesteld");
    exit(0);
} elseif (date("H") < 9) {
    //na tien uur: toon overzicht
    header("location: toonbesteldebroodjes.php?error=natienuur");
    exit(0);
} elseif (isset($_POST["bereken"])) {
    //prijs berekenen
    if (isset($_POST["beleg"])) {
        $prijsBroodje = $broodjeSvc->berekenPrijs($_POST["type"], $_POST["beleg"]);
        $typeBroodje = ($typeSvc->getTypeById($_POST["type"]))->getType();
        $belegBroodje = $belegSvc->getGekozenBeleg($_POST["beleg"]);
    } else {
        $error = "kiesbeleg";
    }
    include("Presentation/broodjeBestellenForm.php"); 
} elseif (isset($_POST["bestel"])) {
    //bestelling verwerken
    if (isset($_POST["beleg"])) {
        $prijsBroodje = $broodjeSvc->berekenPrijs($_POST["type"], $_POST["beleg"]);
        $typeBroodje = ($typeSvc->getTypeById($_POST["type"]))->getType();
        $belegBroodje = $belegSvc->getGekozenBeleg($_POST["beleg"]);
        $broodjeSvc->voegBroodjeToe($typeBroodje, $belegBroodje, $prijsBroodje, $gebruikersId);
        header("location: toonbesteldebroodjes.php");
        exit(0);
    } else {
        $error = "kiesbeleg";
    }
} elseif (isset($_POST["bestelextra"])) {
    //bestelling verwerken
    if (isset($_POST["beleg"])) {
        $prijsBroodje = $broodjeSvc->berekenPrijs($_POST["type"], $_POST["beleg"]);
        $typeBroodje = ($typeSvc->getTypeById($_POST["type"]))->getType();
        $belegBroodje = $belegSvc->getGekozenBeleg($_POST["beleg"]);
        $broodjeSvc->voegBroodjeToe($typeBroodje, $belegBroodje, $prijsBroodje, $gebruikersId);
        $broodjeBesteld = true;
        include("Presentation/broodjeBestellenForm.php");
    } else {
        $error = "kiesbeleg";
    }
} else {
    //toon bestelform
    if (isset($_GET["error"])){
        //foutmelding
        $error = $_GET["error"];
    }
    include("Presentation/broodjeBestellenForm.php");
}