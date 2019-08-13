<?php
//inloggen.php

use Business\GebruikerService;
use Exceptions\UserUnknownException;
use Exceptions\PasswordWrongException;
require_once("Business/GebruikerService.php");
require_once("Exceptions/UserUnknownException.php");
require_once("Exceptions/PasswordWrongException.php");

$gebruikerSvc = new GebruikerService();

if ($gebruikerSvc->getIngelogdeGebruiker()) {
    header("location: bestellen.php");
    exit(0);
} else {
    if (isset($_GET["action"]) && $_GET["action"] == "login") {
        try {
            //login controleren
            $gebruikerSvc = new GebruikerService();
            $gebruikerId = ($gebruikerSvc->controleerLogin($_POST["email"], $_POST["wachtwoord"]))->getId();
            setcookie("gebruiker", $gebruikerId, time()+ 3600*24*14);
            header("location: bestellen.php");
            exit(0);
        } catch (UserUnknownException $ex) {
            $error = "emailunknown";
            include("Presentation/inlogForm.php");
        } catch (PasswordWrongException $ex) {
            $error = "passwordwrong";
            include("Presentation/inlogForm.php");
        }
    } else {
        //loginpagina tonen
        if (isset($_GET["action"]) && $_GET["action"] == "registered") {
            $checkEmail = true;
        }
        if (isset($_GET["action"]) && $_GET["action"] == "changePW") {
            $changePW = true;
        }
        if (isset($_GET["action"]) && $_GET["action"] == "newPW") {
            try {
                $gebruikerSvc->updateWachtwoord($_POST["email"]);
                $newPW = true;
            } catch (UserUnknownException $ex) {
                $changePW = true;
                $error = "emailnotknown";
            }
        }
        include("Presentation/inlogForm.php");
    }
}

