<?php

//Entities/Gebruiker.php

namespace Entities;

class Gebruiker {
    private static $idMap = array();

    private $id;
    private $voornaam;
    private $familienaam;
    private $email;
    private $wachtwoord;

    private function __construct(int $id, string $voornaam, string $familienaam, string $email, string $wachtwoord) {
            $this->id = $id;
            $this->voornaam = $voornaam;
            $this->familienaam = $familienaam;
            $this->email = $email;
            $this->wachtwoord = $wachtwoord;
    }

    public static function create(int $id, string $voornaam, string $familienaam, string $email, string $wachtwoord) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Gebruiker($id, $voornaam, $familienaam, $email, $wachtwoord);
        }
        return self::$idMap[$id];
    }

    public function getId() : int {
            return $this->id;
    }

    public function getVoornaam() : string {
            return $this->voornaam;
    }

    public function getFamilienaam() : string {
            return $this->familienaam;
    }

    public function getEmail() : string {
            return $this->email;
    }

    public function getWachtwoord() : string {
            return $this->wachtwoord;
    }

    public function setVoornaam(string $voornaam) {
            $this->naam = $voornaam;
    }

    public function setFamilienaam(string $familienaam) {
            $this->naam = $familienaam;
    }

    public function setEmail(string $email) {
            $this->email = $email;
    }

    public function setWachtwoord(string $wachtwoord) {
            $this->wachtwoord = $wachtwoord;
    }
}