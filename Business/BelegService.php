<?php

//Business/BelegService.php

namespace Business;

use Data\BelegDAO;
require_once("Data/BelegDAO.php");

class BelegService {
    public function getBelegOverzicht() {
        $belegDAO = new BelegDAO();
        $lijst = $belegDAO->getAll();
        return $lijst;
    }
    
    public function getBelegById(int $id) {
        $belegDAO = new BelegDAO();
        $beleg = $belegDAO->getById($id);
        return $beleg;
    }
    
    public function getGekozenBeleg(array $belegId) {
        $gekozenBeleg = "";
        for ($i = 0; $i < count($belegId); $i++) {
            $gekozenBeleg .= ($this->getBelegById($belegId[$i]))->getBeleg();
            if (count($belegId) > 1 && $i < count($belegId)-2) {
                $gekozenBeleg .= ", ";
            }
            if (count($belegId) > 1 && $i == count($belegId)-2) {
                $gekozenBeleg .= " en ";
            }
        }
        return $gekozenBeleg;
    }
}
    