<?php

//Data/TypeDAO.php

namespace Data;

use Data\DBConfig;
use \PDO;
use Entities\Type;
require_once("DBConfig.php");
require_once("Entities/Type.php");


class TypeDAO {
    public function getAll() : array {
        $sql = "select id, type, prijs from type_broodje";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);

        $lijst = [];
        foreach ($resultSet as $rij) {
            $type = Type::create($rij["id"], $rij["type"], $rij["prijs"]);
            array_push($lijst, $type);
        }
        $dbh = null;
        return $lijst;
    }
    
    public function getById(int $id) {
        $sql = "select id, type, prijs from type_broodje where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':id' => $id
        ));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($rij) {
            $type = Type::create($id, $rij["type"], $rij["prijs"]);
        }
        else {
            $type = null;
        }
        $dbh = null;
        return $type;
    }
}