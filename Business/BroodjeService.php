<?php

//Business/BroodjeService.php

namespace Business;

use Data\BroodjeDAO;
use Business\TypeService;
use Business\BelegService;
require_once("Data/BroodjeDAO.php");
require_once("TypeService.php");
require_once("BelegService.php");

class BroodjeService {
    public function getBroodjesByGebruikerVandaag(int $gebruikersId) {
        $broodjeDAO = new BroodjeDAO();
        $lijst = $broodjeDAO->getByGebruikerVandaag($gebruikersId);
        return $lijst;
    }
    
    public function voegBroodjeToe(string $type, string $beleg, float $prijs, string $gebruikersId) {          
        $broodjeDAO = new BroodjeDAO();
        $broodjeDAO->create($type, $beleg, $prijs, $gebruikersId);
    }
    
    public function berekenPrijs(int $typeId, $belegId) {
        $typeSvc = new TypeService();
        $belegSvc = new BelegService();
        $prijsType = ($typeSvc->getTypeById($typeId))->getPrijs();
        $prijsBeleg = 0;
        if ($belegId) {
            foreach($belegId as $selected){
                $prijsBeleg += ($belegSvc->getBelegById($selected))->getPrijs();
            }
        }
        $prijsBroodje = $prijsType + $prijsBeleg;
        return $prijsBroodje;
    }
}
