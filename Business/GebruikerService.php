<?php

//Business/GebruikerService.php

namespace Business;

use Data\GebruikerDAO;
use Exceptions\UserUnknownException;
use Exceptions\PasswordWrongException;
require_once("Data/GebruikerDAO.php");

class GebruikerService {
    public function voegGebruikerToe(string $voornaam, string $familienaam, string $email) {
        $wachtwoord = $this->genereerWachtwoord();          
        $gebruikerDAO = new GebruikerDAO();
        $gebruikerDAO->create($voornaam, $familienaam, $email, $wachtwoord);
        $this->verstuurWachtwoord($email, $wachtwoord, false);
    }
    
    public function updateWachtwoord(string $email) {
        $gebruikerDAO = new GebruikerDAO();
        $gebruiker = $gebruikerDAO->getByEmail($email);
        if (!is_null($gebruiker)) {
            $id = $gebruiker->getId();
            $wachtwoord = $this->genereerWachtwoord();
            $gebruiker->setWachtwoord($wachtwoord);
            $gebruikerDAO->updateWachtwoord($wachtwoord, $id);
            $this->verstuurWachtwoord($email, $wachtwoord, false);
        } else {
            throw new UserUnknownException;
        }        
    }
    
    public function genereerWachtwoord() : string {
        //TO DO andere opties bekijken
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function verstuurWachtwoord(string $email, string $wachtwoord, bool $nieuweGebruiker) {
        if ($nieuweGebruiker) {
            $msg = "Uw account om broodjes te bestellen werd succesvol aangemaakt.";
            $subject = "Welkom bij de broodjesbar";
        } else {
            $msg = "Uw wachtwoord werd gewijzigd";
            $subject = "Wijziging wachtwoord";
        }
        $msg .= " U kan nu inloggen met de volgende gegevens: \nUw gebruikersnaam: " . $email . "\nUw wachtwoord: " . $wachtwoord;
        $msg = wordwrap($msg,70);
        //TO DO testen
//        mail($email, $subject ,$msg);
    }
    
    public function getGebruikerById(int $id) {
        $gebruikerDAO = new GebruikerDAO();
        $gebruiker = $gebruikerDAO->getById($id);
        return $gebruiker;
    }
    
    public function getGebruikerByEmail(string $email) {
        $gebruikerDAO = new GebruikerDAO();
        $gebruiker = $gebruikerDAO->getByEmail($email);
        return $gebruiker;
    }
    
    public function controleerLogin($email, $wachtwoord) {
        //controleert of gebruiker met emailadres bestaat + combinatie met wachtwoord
        $gebruiker = $this->getGebruikerByEmail($email);
        if ($gebruiker) {
            if ($gebruiker->getWachtwoord() != $wachtwoord) {
                throw new PasswordWrongException;
            }
        } else {
            throw new UserUnknownException;
        }
        return $gebruiker;
    }
    
    public function getIngelogdeGebruiker() {
        //controleert cookies
        if (isset($_COOKIE["gebruiker"])) {
            $id = $_COOKIE["gebruiker"];
            $gebruiker = $this->getGebruikerById($id);
            return $gebruiker;
        }
    }
}