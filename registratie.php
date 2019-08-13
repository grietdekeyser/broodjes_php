<?php

//registratie.php

use Business\GebruikerService;
use Exceptions\EmailExistsException;
require_once("Business/GebruikerService.php");
require_once("Exceptions/EmailExistsException.php");

$gebruikerSvc = new GebruikerService();

if ($gebruikerSvc->getIngelogdeGebruiker()) {
    //ingelogd: verwijzen naar bestelform
    header("location: bestellen.php");
    exit(0);
} else {
    if (isset($_GET["action"]) && $_GET["action"] == "register") {
        //registratie controleren: e-mail uniek?
        try {            
            $gebruikerSvc->voegGebruikerToe($_POST["voornaam"], $_POST["familienaam"], $_POST["email"]);
            header("location: inloggen.php?action=registered");
            exit(0);
        } catch (EmailExistsException $ex) {
            $error = "emailexists";
        }
    }
    include("Presentation/registratieForm.php");
}