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

    /* public function update($table, $data, $field = 'id'){
        $fieldName = null;
        foreach($data as $key=>$value){
            $fieldName .= "$key = :$key, ";
        }
        $fieldName = rtrim($fieldName, ', ');
        //echo $fieldName;
       // echo "<br>UPDATE client SET name = :name, address = :address, phone = :phone, zip_code = :zip_code, email = :email WHERE id = :id<br>" ;

        $sql = "UPDATE $table SET $fieldName WHERE $field = :$field";
        $stmt= $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    } */

    public function update($table, $data, $value, $field = 'id') {
        $fields = '';
        foreach ($data as $key => $val) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');

        $sql = "UPDATE $table SET $fields WHERE $field = :value";
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }
        $stmt->bindValue(':value', $value, PDO::PARAM_INT);

        return $stmt->execute();
    }
}







?>