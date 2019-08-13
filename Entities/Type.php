<?php

//Entities/Type.php

namespace Entities;

class Type {
    private static $idMap = array();

    private $id;
    private $type;
    private $prijs;

    public function __construct(int $id, string $type, float $prijs) {
            $this->id = $id;
            $this->type = $type;
            $this->prijs = $prijs;
    }
    
    public static function create(int $id, string $type, float $prijs) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Type($id, $type, $prijs);
        }
        return self::$idMap[$id];
    }

    public function getId() : int {
            return $this->id;
    }

    public function getType() : string {
            return $this->type;
    }

    public function getPrijs() : float {
            return $this->prijs;
    }

    public function setType(string $type) {
            $this->type = $type;
    }

    public function setPrijs(float $prijs) {
            $this->prijs = $prijs;
    }
}
