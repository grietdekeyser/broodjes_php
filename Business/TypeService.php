<?php

//Business/TypeService.php

namespace Business;

use Data\TypeDAO;
require_once("Data/TypeDAO.php");

class TypeService {
    public function getTypeOverzicht() {
        $typeDAO = new TypeDAO();
        $lijst = $typeDAO->getAll();
        return $lijst;
    }
    
    public function getTypeById(int $id) {
        $typeDAO = new TypeDAO();
        $type = $typeDAO->getById($id);
        return $type;
    }
}