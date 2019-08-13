<?php

//Data/BelegDAO.php

namespace Data;

use Data\DBConfig;
use \PDO;
use Entities\Beleg;
require_once("DBConfig.php");
require_once("Entities/Beleg.php");


class BelegDAO {
    public function getAll() : array {
        $sql = "select id, beleg, prijs from type_beleg";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);

        $lijst = [];
        foreach ($resultSet as $rij) {
            $beleg = Beleg::create($rij["id"], $rij["beleg"], $rij["prijs"]);
            array_push($lijst, $beleg);
        }
        $dbh = null;
        return $lijst;
    }
    
    public function getById(int $id) {
        $sql = "select id, beleg, prijs from type_beleg where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':id' => $id
        ));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $beleg = Beleg::create($id, $rij["beleg"], $rij["prijs"]);
        $dbh = null;
        return $beleg;
    }
}