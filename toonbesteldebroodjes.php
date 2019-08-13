<?php

//toonbesteldebroodjes.php

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

if (!$gebruiker) {
    //niet ingelogd: verwijzen naar inlogform
    header("location: inloggen.php"); 
    exit(0);
} else {
    $naamGebruiker = $gebruiker->getVoornaam();
    $gebruikersId = $gebruiker->getId();
    
    // lijst bestelde broodjes gebruiker
    $broodjeSvc = new BroodjeService();
    $tabBroodje = $broodjeSvc->getBroodjesByGebruikerVandaag($gebruikersId);
    
    if (isset($_GET["error"])){
        //foutmelding
        $error = $_GET["error"];
    }
    
    include("Presentation/broodjesTabel.php");
}

