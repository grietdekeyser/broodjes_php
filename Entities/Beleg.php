<?php

//Entities/Beleg.php

namespace Entities;

class Beleg {
    private static $idMap = array();

    private $id;
    private $beleg;
    private $prijs;

    public function __construct(int $id, string $beleg, float $prijs) {
            $this->id = $id;
            $this->beleg = $beleg;
            $this->prijs = $prijs;
    }
    
    public static function create(int $id, string $beleg, float $prijs) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Beleg($id, $beleg, $prijs);
        }
        return self::$idMap[$id];
    }

    public function getId() : int {
            return $this->id;
    }

    public function getBeleg() : string {
            return $this->beleg;
    }

    public function getPrijs() : float {
            return $this->prijs;
    }

    public function setBeleg(string $beleg) {
            $this->beleg = $beleg;
    }

    public function setPrijs(float $prijs) {
            $this->prijs = $prijs;
    }
}