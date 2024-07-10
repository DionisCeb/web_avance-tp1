<?php
class CRUD extends PDO {
    public function __construct(){
        parent::__construct('mysql:host=localhost;dbname=car_rent;port=3306; charset=utf8', 'root','');
    }

     /* Fonction de sélection générique pour récupérer toutes les lignes d'une table
     @param string $table Le nom de la table
     @param string $field Le champ à trier (par défaut : 'id')
     @param string $order L'ordre de tri (par défaut : 'ASC')
     @return array Tableau associatif contenant toutes les lignes de la table */
 
     public function select($table, $field = 'id', $order = 'ASC') {
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectById($table, $value, $field = 'id') {
        $sql = "SELECT * FROM $table WHERE $field = :value";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':value', $value, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $this->lastInsertId();
    }
}







?>