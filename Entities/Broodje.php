<?php

//Entities/Broodje.php

namespace Entities;

class Broodje {
    private static $idMap = array();

    private $id;
    private $type;
    private $beleg;
    private $prijs;
    private $gebruiker;
    private $datum;

    public function __construct(int $id, string $type, string $beleg, float $prijs, string $gebruiker, string $datum) {
            $this->id = $id;
            $this->type = $type;
            $this->beleg = $beleg;
            $this->prijs = $prijs;
            $this->gebruiker = $gebruiker;
            $this->datum = $datum;
    }
    
    public static function create(int $id, string $type, string $beleg, float $prijs, string $gebruiker, string $datum) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Broodje($id, $type, $beleg, $prijs, $gebruiker, $datum);
        }
        return self::$idMap[$id];
    }

    public function getId() : int {
            return $this->id;
    }

    public function getType() : string {
            return $this->type;
    }

    public function getBeleg() : string {
            return $this->beleg;
    }

    public function getPrijs() : float {
            return $this->prijs;
    }

    public function getGebruiker() : string {
            return $this->gebruiker;
    }

    public function getDatum() : string {
            return $this->datum;
    }

    public function setType(string $type) {
            $this->type = $type;
    }

    public function setBeleg(string $beleg) {
            $this->beleg = $beleg;
    }

    public function setPrijs(float $prijs) {
            $this->prijs = $prijs;
    }

    public function setGebruiker(string $gebruiker) {
            $this->gebruiker = $gebruiker;
    }

    public function setDatum(string $datum) {
            $this->datum = $datum;
    }
}