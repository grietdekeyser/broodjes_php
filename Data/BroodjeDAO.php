<?php

//Data/BroodjeDAO.php

namespace Data;

use Data\DBConfig;
use \PDO;
use Entities\Broodje;
require_once("DBConfig.php");
require_once("Entities/Broodje.php");


class BroodjeDAO {
    public function getAll() : array {
        $sql = "select id, type, beleg, prijs, gebruikersId, datum from broodjes";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);

        $lijst = [];
        foreach ($resultSet as $rij) {
            $broodje = Broodje::create($rij["id"], $rij["type"], $rij["beleg"], $rij["prijs"], $rij["gebruikersId"], $rij["datum"]);
            array_push($lijst, $broodje);
        }
        $dbh = null;
        return $lijst;
    }
    
    public function getById(int $id) {
        $sql = "select id, type, beleg, prijs, gebruikersId, datum from broodjes where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':id' => $id
        ));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
       
        $broodje = Broodje::create($id, $rij["type"], $rij["beleg"], $rij["prijs"], $rij["gebruikersId"], $rij["datum"]);
        $dbh = null;
        return $broodje;
    }
    
    public function getByGebruikerVandaag(int $gebruikersId) {
        $vandaag = date("Y-m-d");
        $datum = $vandaag . "%";
        
        $sql = "select id, type, beleg, prijs, gebruikersId, datum from broodjes where gebruikersId = :gebruikersId and datum like :datum";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':gebruikersId' => $gebruikersId,
            ':datum' => $datum
        ));
        $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $lijst = [];
        if ($resultSet) {
            foreach ($resultSet as $rij) {
                $broodje = Broodje::create($rij["id"], $rij["type"], $rij["beleg"], $rij["prijs"], $gebruikersId, $rij["datum"]);
                array_push($lijst, $broodje);
            }
        }
        else {
            $lijst = null;
        }
        $dbh = null;
        return $lijst;
    }
    
    public function create(string $type, string $beleg, float $prijs, string $gebruikersId) {
        $sql = "insert into broodjes (type, beleg, prijs, gebruikersId) values (:type, :beleg, :prijs, :gebruikersId)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':type' => $type,
            ':beleg' => $beleg,
            ':prijs' => $prijs,
            ':gebruikersId' => $gebruikersId
        ));

        $id = $dbh->lastInsertId();
        $datum = ($this->getById($id))->getDatum();
        $broodje = Broodje::create($id, $type, $beleg, $prijs, $gebruikersId, $datum);
        $dbh = null;
        return $broodje;
    }
}